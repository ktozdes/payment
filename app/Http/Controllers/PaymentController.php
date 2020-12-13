<?php

namespace App\Http\Controllers;

use App\Events\PaymentFinished;
use App\Models\Card;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$searchFilter = [];
        $orderBy = isset($request->filter['sort_by']) ? :'payments.id';
        $query = Payment
            ::select(['payments.id as id', 'token', 'full_name', 'phone', 'email', 'payed_at', 'cards.type as type', 'amount'])
            ->leftJoin('cards', 'cards.id', 'payments.card_id');
        if (isset($request->filter['token']) && !empty($request->filter['token'])) {
            $query->where('token', 'like', '%' . $request->filter['token'] . '%');
        }
        if (isset($request->filter['full_name']) && !empty($request->filter['full_name'])) {
            $query->where('full_name', 'like', '%' . $request->filter['full_name'] . '%');
        }
        if (isset($request->filter['card_type']) && !empty($request->filter['card_type'])) {
            $query->where('type', $request->filter['card_type'] );
        }
        $query->orderBy($orderBy, 'desc');
        //echo $query->orderBy($orderBy, 'desc')->toSql();
        $items = $query->paginate( config('app.paginate_by', '25') )->onEachSide(2);
        return view('payment.index', [
            'items' => $items,
            'filters' => $request->filter,
            'statuses' => $request->filter,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('payment.create', [
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount'=>'required',
            'email' => 'nullable|email',
        ]);
        $payment = new Payment($request->all());
        $payment->amount = floatval(preg_replace("/[^-0-9\.]/","",$request->amount));
        $payment->token = $this->generateUniqueToken();
        $payment->save();

        return redirect()->route('payment.show', $payment->id)->withSuccess(__('Payment Created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //$searchFilter = [];
        $payment->load('card');
        return view('payment.show', [
            'item' => $payment,
            'histories' => $payment->histories()->orderBy('created_at', 'desc')->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        if (!$payment->card && isset($payment->current_status) && $payment->current_status->code =='created') {
            return view('payment.edit', [
                'item' => $payment,
                'histories' => $payment->histories()->orderBy('created_at', 'desc')->get(),
            ]);
        }
        return redirect()->route('payment.front.show', $payment->token)->withError(__('Payment cannot be edited'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        if (!$payment->card && isset($payment->current_status) && $payment->current_status->code =='created') {
            $request->validate([
                'owner' => 'required',
                'number' => ['required',
                    function ($attribute, $value, $fail) {
                        $value = preg_replace('/[^0-9.]+/', '', $value);
                        if (strlen($value) != 16) {
                            $fail(__('Card number has to be 16 digits'));
                        }
                    },
                    function ($attribute, $value, $fail) {
                        $value = preg_replace('/[^0-9.]+/', '', $value);
                        $length = strlen($value);
                        $sum = (int)$value[$length - 1];
                        $parity = $length % 2;
                        for ($index = 0; $index < $length - 1; $index++) {
                            $digit = (int)$value[$index];
                            if ($index % 2 == $parity) {
                                $digit *= 2;
                            }
                            if ($digit > 9) {
                                $digit -= 9;
                            }
                            $sum += $digit;
                        }
                        if (($sum % 10 != 0)) {
                            $fail(__('Invalid card number'));
                        }
                    },
                ],
                'expiration_date' => ['required',
                    function ($attribute, $value, $fail) {
                        $values = explode('/', $value);
                        if (isset($values[0]) && is_numeric($values[0]) && $values[0] > 0 && $values[0] < 13) {

                            if (isset($values[1]) && is_numeric($values[1]) && $values[1] >= date("y") && $values[1] <= (date("y") + 5)) {
                                try {
                                    $cardDate = Carbon::createFromFormat('y-m-d H:i:s', "{$values[1]}-{$values[0]}-1 00:00:01");
                                    $fiveYears = Carbon::now()->addYears(5);
                                    if ($cardDate < Carbon::now() || $cardDate > $fiveYears) {
                                        $fail(__('Invalid date'));
                                    }
                                } catch (\Carbon\Exceptions\InvalidDateException $exp) {
                                    $fail(__('Invalid date'));
                                }
                            } else {
                                $fail(__('Invalid year'));
                            }
                        } else {
                            $fail(__('Invalid month'));
                        }
                    }
                ],
                'ccv' => 'required|numeric',
            ]);
            $allRequests = $request->all();
            $number = preg_replace('/[^0-9.]+/', '', $allRequests['number']);
            $allRequests['number'] = substr($number, 0, 6) . '******' . substr($number, -4);
            $card = Card::create(
                $allRequests
            );
            $payment->update([
                'card_id' => $card->id,
                'payed_at' => Carbon::now(),
            ]);
            return redirect()->route('payment.front.show', $payment->token)->withSuccess(__('Payment is updated'));
        }
        return redirect()->route('payment.front.show', $payment->token)->withError(__('Payment cannot be edited'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function finish(Payment $payment)
    {
        if (!$payment->card && isset($payment->current_status) && $payment->current_status->code =='created') {
            event(new PaymentFinished($payment));
            return redirect()->route('payment.show', $payment->id)->withSuccess(__('Payment Finished'));
        }
        return redirect()->route('payment.show', $payment->id)->withError(__('Payment Not Finished'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return string
     */
    private function generateUniqueToken() {
        $str = Str::random(100);
        $payment = Payment::where('token', $str)->get();

        if ( $payment->isEmpty() ) {
            return $str;
        }
        return $this->generateUniqueToken();
    }
}
