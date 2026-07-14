<div class="col-lg-9 transfer-page">
    <div class="profile-content">
        <h3 class="admin-heading">{{ translate(409) }} {{ $transfert_ref_msg }}</h3>

        <x-alert />

        <x-transfer-nav-pills step="1" />

        <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

            <form method="post" action="" class="breakTag form transfer-form" data-message="{{ translate(212) }}">
                @csrf

                <section class="transfer-section">
                    <h3 class="transfer-section-title">1. {{ translate(411) }}</h3>

                    <div class="form-group transfer-methods">
                        <div class="row">

                            @if (ALLOW_WITHDRAWALS_TO_CARD)
                                <div class="col-lg-4 transfer-method">
                                    <label @class(['transfert_to__label', 'active' => ($currentTab === 'cards')]) for="bcard">
                                        <input id="bcard" wire:model="currentTab" type="radio" name="payment_method" value="cards" class="pay_methds" required>
                                        <span><i class="fa fa-credit-card mr-1"></i>{{ translate(587) }}</span>
                                    </label>
                                </div>
                            @endif

                            @if (ALLOW_WITHDRAWALS_TO_BANK)
                                <div class="col-lg-4 transfer-method">
                                    <label @class(['transfert_to__label', 'active' => ($currentTab === 'recipients')]) for="bktransfert">
                                        <input id="bktransfert" checked wire:model="currentTab" type="radio" name="payment_method" value="recipients" class="pay_methds" required>
                                        <span><i class="fa fa-university mr-1"></i>{{ translate(619) }}</span>
                                    </label>
                                </div>
                            @endif

                            @if (ALLOW_WITHDRAWALS_TO_PAYPAL)
                                <div class="col-lg-4 transfer-method">
                                    <label @class(['transfert_to__label', 'active' => ($currentTab === 'paypal')]) for="ppl">
                                        <input id="ppl" wire:model="currentTab" type="radio" name="payment_method" value="paypal" class="pay_methds" required>
                                        <span><i class="fab fa-paypal mr-1"></i>{{ translate(620) }}</span>
                                    </label>
                                </div>
                            @endif

                        </div>
                    </div>
                    <div>

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
                            <div class="form-group bank-recipient-box">
                                <div class="recipient-mode mb-3">
                                    <label for="recipient_new" @class(['active' => $recipientMode === 'new'])>
                                        <input id="recipient_new" type="radio" wire:model="recipientMode" name="recipient_mode" value="new">
                                        <i class="fa fa-plus-circle"></i>
                                        <span>{{ translate(104) }}</span>
                                    </label>
                                    @if ($recipients->count())
                                        <label for="recipient_existing" @class(['active' => $recipientMode === 'existing'])>
                                            <input id="recipient_existing" type="radio" wire:model="recipientMode" name="recipient_mode" value="existing">
                                            <i class="fa fa-user-check"></i>
                                            <span>{{ translate(622) }}</span>
                                        </label>
                                    @endif
                                </div>

                                @if ($recipientMode === 'new')
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="required-field">{{ translate(323) }}</label>
                                                <input type="text" name="new_recipient_name" class="form-control input-lg" value="{{ old('new_recipient_name') }}" autocomplete="name" placeholder="John Doe" required>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <div class="form-group">
                                                <label class="required-field">{{ translate(325) }}</label>
                                                <input type="text" name="new_recipient_iban" class="form-control input-lg text-uppercase" value="{{ old('new_recipient_iban') }}" autocomplete="off" placeholder="FR76..." required>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-5">
                                            <div class="form-group">
                                                <label class="required-field">{{ translate(317) }}</label>
                                                <input type="text" name="new_recipient_bic" class="form-control input-lg text-uppercase" value="{{ old('new_recipient_bic') }}" autocomplete="off" placeholder="ABCDEFGH" required>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group mb-0">
                                        <label class="required-field">{{ translate(412) }}</label>
                                        <select class="form-control input-lg" name="payment_method_id" required>
                                            <option value="">{{ translate(412) }}</option>
                                            @foreach ($recipients as $recipient)
                                                <option value="{{ $recipient->id }}">{{ $recipient->recipient_name }} ({{ hideIbanPart($recipient->recipient_iban) }})</option>
                                            @endforeach
                                        </select>
                                    </div>
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
                </section>

                <section class="transfer-section">
                    <h3 class="transfer-section-title">2. {{ translate(416) }}</h3>
                    <div class="transfer-amount-panel">
                        <div class="form-group mb-0">
                            <label class="sr-only required-field" for="transfer-amount">{{ translate(416) }}</label>
                            <div @class(['transfer-amount-input', 'is-invalid' => $balanceTypingError])>
                                <input class="form-control transfer-amount-control" id="transfer-amount" type="number" inputmode="decimal" min="0.01" step="0.01" wire:model.debounce.200ms="balance_typing" autocomplete="off" name="amount" placeholder="0.00" aria-describedby="transfer-currency transfer-remaining-balance" onkeydown="return !['e', 'E', '+', '-'].includes(event.key)" required>
                                <span class="transfer-currency-code" id="transfer-currency">{{ $customer->currency->name }}</span>
                            </div>
                            <div class="transfer-balance-line" id="transfer-remaining-balance">
                                <span>{{ translate(392) }}</span>
                                <strong>{{ setCurrency($customer->currency, $newBalance) }}</strong>
                            </div>
                            @if ($balanceTypingError)
                                <p class="transfer-balance-error" role="alert">{{ translate(53) }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="form-group d-none hidden">
                        <label>{{ translate(417) }}</label>
                        <input type="hidden" autocapitalize="nope" autocomplete="nope" autocorrect="off" class="form-control input-lg" name="reference" value="{{ $transfert_ref_msg }}" required>
                    </div>

                    <div class="btns-group transfer-actions">
                        <button type="submit" id="completedChallenge" class="btn btn-success btn-lg" @disabled($balanceTypingError)>{{ translate(418) }}</button>
                    </div>
                </section>
            </form>
            
          </div>
        </div>
    </div>
</div>
