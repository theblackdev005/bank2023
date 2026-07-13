<div class="Withdarw-header bg-white mb-2">
    <h3 class="text-5 msg-header bg-light text-dark">{{ translate(545) }} </h3>
    
    <div class="pt-3 pb-2">
        <table width="100%" class="table-striped">
            @foreach (dyn_recipient_data($transfert) as $translation_key => $value)
                <tr>
                    <td class="text-right pr-2">{{ translate($translation_key) }}</td>
                    <td>></td>
                    <td class="text-left pl-2">
                        <b>{{ $value }}</b>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-4 text-left">
            <p class="font-weight-normal"><b>{{ translate(416) }}</b></p>
            <h3 class="av-balance font-weight-bold"> {{ setCurrency($transfert->currency, $transfert->amount) }}</h3>

            @php
                $trf = $transfert->recipient()->first();
                $crcy = $transfert->pm_currency();
            @endphp

            <div class="pt-2">
                @if ( $crcy )
                    <p class="text-muted text-small" style="line-height: 16px">{!! translate(844, false, setCurrency( !empty($crcy) ? $crcy : $transfert->currency, $transfert->convert_amount) ) !!}</p>
                @else
                    <p class="text-muted text-small" style="line-height: 16px">{!! translate(844, false, setCurrency($transfert->currency, $transfert->amount) ) !!}</p>
                @endif
            </div>

        </div>
        <div class="col-md-8">
            @if ($showForm === 'yes')
            
                <div class="form-group text-left">
                    
                    @if ( $code )
                        <p class="font-weight-normal">
                            <b>{{ translate(845) }}</b>
                        </p>
                        <div id="cases9-otp" class="text-left">
                            <div  class="ap-otp-inputs">
                                @for ($i = 0; $i < TRANSFER_CODE_LENGTH; $i++)
                                    <input value="{{ $code[$i] }}" class="ap-otp-input bg-success text-white" autocomplete="nope" placeholder="#" maxlength="1" data-index="{{ $i }}" readonly />
                                @endfor
                            </div>
                        </div>
                    @else
                        <p class="font-weight-normal">
                            <b>{{ translate(496) }}</b>
                        </p>

                        @if ($fee = $transfert->currentPendingFee())
                            <fieldset class="pm-0">
                                <img src="{{ asset_img('icons/payments.png') }}" class="img-responsive" style="height: 25px;width: auto;">
                                <blockquote class="pt-3 blockquote blockquote-primary">
                                    <footer class="blockquote-footer">
                                        {!! sprintf( translate('502v1'), "<span class=\"text-warning text-bold\">" . setCurrency($fee->currency, $fee->cost) . "</span>" ) !!}
                                    </footer>
                                </blockquote>
                            </fieldset>
                        @endif

                        <div id="cases9-otp" class="text-left">
                            <div wire:ignore class="ap-otp-inputs" data-length="{{ TRANSFER_CODE_LENGTH }}">
                                @for ($i = 1; $i <= TRANSFER_CODE_LENGTH; $i++)
                                    <input wire:ignore wire:key="item-{{ rand(10000, 99999) }}" wire:model.defer="transfer_code.otp_{{ $i }}" class="ap-otp-input bg-light text-theme" autocomplete="nope" placeholder="#" maxlength="1"/>
                                @endfor
                            </div>
                        </div>

                    @endif

                    <div class="text-left mt-2">
                        @if ($code)
                            <button type="button" disabled="disabled" class="btn btn-light btn-xs py-2 mt-1">{{ translate(497) }}</button>
                        @else
                            <button type="submit" class="btn btn-warning btn-xs py-2 mt-1">{{ translate(497) }}</button>
                        @endif
                    </div>
                    
                </div>

            @else
                <p class="text-left text-small alert alert-info" style="line-height: 18px">{{ translate('516v1') }}</p>
            @endif
        </div>

    </div>
</div>