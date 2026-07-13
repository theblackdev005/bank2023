<div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label class="required-field">{{ translate(323) }}</label>
                <div class="form-group">
                    <input type="text" autocapitalize="none" autocomplete="nope" autocorrect="off" class="form-control input-lg" name="recipient_name" placeholder="John Doe" required>
                </div>
            </div>
            <div class="col-md-6 pt-m">
                <label>{{ translate(324) }}</label>
                <div class="form-group">
                    <input type="text" autocapitalize="none" autocomplete="nope" autocorrect="off" class="form-control input-lg" name="recipient_address">
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <h3 class="admin-heading mb-4">{{ translate(640) }}</h3>
        
        <div class="row">
            <div class="col-md-6">
                <label for="ihave_iban_swift" class="d-block">
                    <input wire:model="ihave" id="ihave_iban_swift" name="ihave" value="iban_swift" type="radio">
                    <span>{{ translate(639) }}</span>
                </label>
            </div>
            <div class="col-md-6">
                <label for="ihave_account_num" class="d-block">
                    <input wire:model="ihave" id="ihave_account_num" name="ihave" value="account_num" type="radio">
                    <span>{{ translate(638) }}</span>
                </label>
            </div>
        </div>

        @if ($ihave === 'iban_swift')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" autocapitalize="none" placeholder="{{ translate(325) }}" autocomplete="nope" autocorrect="off" class="form-control input-lg" id="iban" name="recipient_iban" required>
                    </div>
                </div>
                <div class="col-md-6 pt-m">
                    <div class="form-group">
                        <input type="text" autocapitalize="none" placeholder="{{ translate(317) }}" autocomplete="nope" autocorrect="off" class="form-control input-lg" name="bank_swift" required>
                    </div>
                </div>
            </div>
        @endif

        @if ($ihave === 'account_num')
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="text" autocapitalize="none" placeholder="{{ translate(487) }}" autocomplete="nope" autocorrect="off" class="form-control input-lg" id="iban" name="account_number" required>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="form-group">
        <h3 class="admin-heading mb-4">{{ translate(554) }}</h3>
        <div class="row">
            <div class="col-md-6">
                <label class="required-field">{{ translate(318) }}</label>
                <div class="form-group">
                    <input type="text" autocapitalize="none" autocomplete="nope" autocorrect="off" class="form-control input-lg" name="bank_name" required>
                </div>
            </div>
            <div class="col-md-6 pt-m"> 
                <x-recipients-currency-field :currencies=$currencies />
            </div>
        </div>
    </div>

    <div class="form-group">
        <label>{{ translate(319) }}</label>
        <div class="form-group">
            <input type="text" autocapitalize="none" autocomplete="nope" autocorrect="off" class="form-control input-lg" name="bank_address">
        </div>
    </div>
</div>