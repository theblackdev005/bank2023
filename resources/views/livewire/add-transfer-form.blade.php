<div class="col-lg-9">
    <div class="profile-content">
        <h3 class="admin-heading">{{ translate(409) }} {{ $transfert_ref_msg }}</h3>

        <x-transfer-nav-pills step="1" />

        <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

            <form method="post" action="" class="breakTag form bg-offwhite py-5" data-message="{{ translate(212) }}">
                @csrf
                
                <h3 class="text-muted">1. {{ translate(411) }}</h3>

                <div class="bg-white border rounded px-5 py-3 mb-4">
                    <div class="form-group pt-2">
                        <div class="row">

                            @if (ALLOW_WITHDRAWALS_TO_CARD)
                                <div class="col-lg-4">
                                    <label @class(['transfert_to__label', 'active' => ($currentTab === 'cards')]) for="bcard">
                                        <input id="bcard" wire:model="currentTab" type="radio" name="payment_method" value="cards" class="pay_methds" required>
                                        <span><i class="fa fa-credit-card mr-1"></i>{{ translate(587) }}</span>
                                    </label>
                                </div>
                            @endif

                            @if (ALLOW_WITHDRAWALS_TO_BANK)
                                <div class="col-lg-4">
                                    <label @class(['transfert_to__label', 'active' => ($currentTab === 'recipients')]) for="bktransfert">
                                        <input id="bktransfert" checked wire:model="currentTab" type="radio" name="payment_method" value="recipients" class="pay_methds" required>
                                        <span><i class="fa fa-university mr-1"></i>{{ translate(619) }}</span>
                                    </label>
                                </div>
                            @endif

                            @if (ALLOW_WITHDRAWALS_TO_PAYPAL)
                                <div class="col-lg-4">
                                    <label @class(['transfert_to__label', 'active' => ($currentTab === 'paypal')]) for="ppl">
                                        <input id="ppl" wire:model="currentTab" type="radio" name="payment_method" value="paypal" class="pay_methds" required>
                                        <span><i class="fab fa-paypal mr-1"></i>{{ translate(620) }}</span>
                                    </label>
                                </div>
                            @endif

                        </div>
                    </div>
                    <div class="">

                        @if ($currentTab === 'cards')
                            <div class="form-group">
                                @if ($cards)
                                    <div class="row">
                                        <div class="col-12 col-lg-12">
                                            <label class="required-field">{{ translate(618) }}</label>
                                            <select class="form-control input-lg" name="payment_method_id" required>
                                                <option value="">{{ translate(621) }}</option>
                                                @foreach ($cards as $card)
                                                    <option {{ disabled_if(!$card->isApproved()) }} value="{{ $card->id }}">{{ hideCardNumber($card->number) }} ({{ $card->expire }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @else
                                    <p class="pm-0 text-muted">
                                        <span class="text-block">{{ translate(625) }}</span>
                                        <a href="{{ routeWithLocale('customer.add_cards') }}" class="btn btn-dark mt-1"><i class="fa fa-credit-card"></i> {{ translate(609) }}</a>
                                    </p>
                                @endif
                            </div>
                        @endif
                        
                        @if ($currentTab === 'recipients')
                            <div class="form-group">
                                @if ($recipients)
                                    <div class="row">
                                        <div class="col-12 col-lg-12">
                                            <label class="required-field">{{ translate(622) }}</label>
                                            <select class="form-control input-lg" name="payment_method_id" required>
                                                <option value=""> {{ translate(412) }}</option>
                                                @foreach ($recipients as $recipient)
                                                    <option {{ disabled_if(!$recipient->isApproved()) }} value="{{ $recipient->id }}">{{ $recipient->recipient_name }} ({{ $recipient->country->name }} - {{ $recipient->currency->name }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 col-lg-12">
                                            <hr>
                                            <span class="text-block">{{ translate(468) }}</span>
                                            <div class="py-2">
                                                <a class="btn btn-secondary btn-sm" href="{{ routeWithLocale('customer.add_recipients') }}">{{ translate(93) }}</a>
                                            </div>
                                            <span class="text-block text-bold text-danger mt-2">{{ translate(469) }}</span>
                                        </div>
                                    </div>
                                @else
                                    <p class="pm-0 text-muted">
                                        <span class="text-block">{{ translate(468) }}</span>
                                        <span class="text-block text-bold text-danger mb-2">{{ translate(469) }}</span>
                                        <a href="{{ routeWithLocale('customer.recipients') }}" class="btn btn-dark mt-1"><i class="fa fa-university"></i> {{ translate(636) }}</a>
                                    </p>
                                @endif
                            </div>
                        @endif
                        
                        @if ($currentTab === 'paypal')
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="add_ppl" class="mr-2">
                                        <input wire:model="chooseOrAddPpl" @checked($chooseOrAddPpl == 1) type="radio" value="1" id="add_ppl"> {{ translate(648) }}
                                    </label>
                                    <label wire:click="retreivePaypal()" for="choose_ppl">
                                        <input wire:model="chooseOrAddPpl" type="radio" value="2" id="choose_ppl"> {{ translate(624) }}
                                    </label>
                                </div>

                                @if ($chooseOrAddPpl == 1)
                                    <div class="form-group">
                                        <label for="">{{ translate(617) }}</label>
                                        <input type="email" @disabled($paypal_form_spinner) @class([
                                            "form-control",
                                            "border" => $paypal_form_error,
                                            "border-danger" => $paypal_form_error,
                                            "is-invalid" => $paypal_form_error
                                        ]) wire:model="paypal_email" autocomplete="nope" placeholder="john.doe@gmail.com" required>
                                        
                                        @if ($paypal_form_error_msg)
                                            <div id="paypal_form_error_msg">
                                                <strong class="text-danger">{{ $paypal_form_error_msg }}</strong>
                                            </div>
                                        @endif

                                        <div class="d-flex mt-3 align-items-center">
                                            <input type="button" wire:click="addPaypalAccount()" class="btn btn-default" value="{{ translate(648) }}">
                                            <img wire:loading class="tiny__spinner" src="{{ asset_img('../banking/images/animated_spinner.gif') }}" alt="">
                                        </div>
                                    </div>
                                @endif
                                
                                @if ($chooseOrAddPpl == 2)
                                    <div class="form-group">
                                        <label class="required-field">{{ translate(623) }}</label>

                                        @if ($paypals->count())
                                            <select class="form-control input-lg" name="payment_method_id" required>
                                                <option value=""> {{ translate(624) }}</option>
                                                @foreach ($paypals as $paypal)
                                                    <option {{ disabled_if(!$paypal->isApproved()) }} value="{{ $paypal->id }}">{{ hideEmailAddress($paypal->paypal_email) }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <p class="text-muted">{{ translate(658) }}</p>
                                        @endif
                                    </div>
                                @endif
                                
                            </div>
                        @endif
                        
                    </div>
                </div>
                
                <div>
                    <h3 class="text-muted">2. {{ translate(413) }}</h3>
                    <div class="form-group">
                        <label class="required-field">{{ translate(414) }}</label>
                        <select class="form-control input-lg" name="customer_id" required>
                            <option value=""> {{ translate(415) }} </option>
                            <option value="{{ $customer->id }}">{{ $customer->fullname() }} ( {{ $customer->username . ' - ' . $customer->currency->name }} )</option>
                        </select>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group mt-2">
                        <label class="required-field">{{ translate(416) }}</label>
                        <div @class([
                            'card',
                            'h4',
                            'text-white',
                            'text-center',
                            'bg-danger'     => $balanceTypingError,
                            'bg-success'    => !$balanceTypingError])>
                            <div>{{ setCurrency($customer->currency, $balance_typing) }} / {{ setCurrency($customer->currency, $customer->balance) }}</div>
                        </div>
                        <input @class([
                            'form-control',
                            'input-lg',
                            'border-danger' => $balanceTypingError
                        ]) type="text" wire:model="balance_typing" wire:keyup="updateBalanceAfterTyping()" autocapitalize="none" autocomplete="nope" autocorrect="off" name="amount" placeholder="" required>
                    </div>
                </div>

                <div class="form-group d-none hidden">
                    <label>{{ translate(417) }}</label>
                    <input type="hidden" autocapitalize="nope" autocomplete="nope" autocorrect="off" class="form-control input-lg" name="reference" value="{{ $transfert_ref_msg }}" required>
                </div>

                <div class="btns-group">
                    <button type="submit" id="completedChallenge" class="btn btn-success btn-lg">{{ translate(418) }}</button>
                </div>
            </form>
            
          </div>
        </div>
    </div>
</div>