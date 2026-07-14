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
                                        <input id="bktransfert" wire:model="currentTab" type="radio" name="payment_method" value="recipients" class="pay_methds" required>
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
                            <div class="form-group bank-recipient-box">
                                <div class="recipient-mode mb-3">
                                    <label for="card_new" @class(['active' => $cardMode === 'new'])>
                                        <input id="card_new" type="radio" wire:model="cardMode" name="card_mode" value="new">
                                        <i class="fa fa-plus-circle"></i>
                                        <span>{{ translate(609) }}</span>
                                    </label>
                                    @if ($cards->count())
                                        <label for="card_existing" @class(['active' => $cardMode === 'existing'])>
                                            <input id="card_existing" type="radio" wire:model="cardMode" name="card_mode" value="existing">
                                            <i class="fa fa-credit-card"></i>
                                            <span>{{ translate(621) }}</span>
                                        </label>
                                    @endif
                                </div>

                                @if ($cardMode === 'new')
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="required-field" for="new-card-owner">{{ translate(614) }}</label>
                                                <input id="new-card-owner" type="text" name="new_card_owner" class="form-control input-lg" value="{{ old('new_card_owner') }}" autocomplete="cc-name" placeholder="John Doe" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="required-field" for="new-card-number">{{ translate(611) }}</label>
                                                <input id="new-card-number" type="tel" name="new_card_number" class="form-control input-lg" value="{{ old('new_card_number') }}" inputmode="numeric" autocomplete="cc-number" placeholder="0000 0000 0000 0000" required>
                                            </div>
                                        </div>
                                        <div class="col-7 col-md-6">
                                            <div class="form-group">
                                                <label class="required-field" for="new-card-expire">{{ translate(612) }}</label>
                                                <input id="new-card-expire" type="tel" name="new_card_expire" class="form-control input-lg" value="{{ old('new_card_expire') }}" inputmode="numeric" autocomplete="cc-exp" maxlength="7" placeholder="MM/YYYY" required>
                                            </div>
                                        </div>
                                        <div class="col-5 col-md-4">
                                            <div class="form-group">
                                                <label class="required-field" for="new-card-cvv">{{ translate(613) }}</label>
                                                <input id="new-card-cvv" type="password" name="new_card_cvv" class="form-control input-lg" inputmode="numeric" autocomplete="cc-csc" minlength="3" maxlength="4" placeholder="CVV" required>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group mb-0">
                                        <label class="required-field" for="existing-card">{{ translate(618) }}</label>
                                        <select id="existing-card" class="form-control input-lg" name="payment_method_id" required>
                                            <option value="">{{ translate(621) }}</option>
                                            @foreach ($cards as $card)
                                                <option value="{{ $card->id }}" @if ((string) old('payment_method_id') === (string) $card->id) selected @endif>{{ hideCardNumber($card->number) }} ({{ $card->expire }})</option>
                                            @endforeach
                                        </select>
                                    </div>
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
                            <div class="form-group bank-recipient-box">
                                <div class="recipient-mode mb-3">
                                    <label for="paypal_new" @class(['active' => $paypalMode === 'new'])>
                                        <input id="paypal_new" type="radio" wire:model="paypalMode" name="paypal_mode" value="new">
                                        <i class="fa fa-plus-circle"></i>
                                        <span>{{ translate(648) }}</span>
                                    </label>
                                    @if ($paypals->count())
                                        <label for="paypal_existing" @class(['active' => $paypalMode === 'existing'])>
                                            <input id="paypal_existing" type="radio" wire:model="paypalMode" name="paypal_mode" value="existing">
                                            <i class="fab fa-paypal"></i>
                                            <span>{{ translate(624) }}</span>
                                        </label>
                                    @endif
                                </div>

                                @if ($paypalMode === 'new')
                                    <div class="form-group mb-0">
                                        <label class="required-field" for="new-paypal-email">{{ translate(617) }}</label>
                                        <input id="new-paypal-email" type="email" class="form-control input-lg" name="new_paypal_email" value="{{ old('new_paypal_email') }}" autocomplete="email" placeholder="john.doe@gmail.com" required>
                                    </div>
                                @else
                                    <div class="form-group mb-0">
                                        <label class="required-field" for="existing-paypal">{{ translate(623) }}</label>
                                        <select id="existing-paypal" class="form-control input-lg" name="payment_method_id" required>
                                            <option value="">{{ translate(624) }}</option>
                                            @foreach ($paypals as $paypal)
                                                <option value="{{ $paypal->id }}" @if ((string) old('payment_method_id') === (string) $paypal->id) selected @endif>{{ hideEmailAddress($paypal->paypal_email) }}</option>
                                            @endforeach
                                        </select>
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
