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
                <label>{{ translate(183) }}</label>
                <div class="form-group">
                  <input type="text" autocapitalize="none" placeholder="00-0000-0000000-00" autocomplete="nope" autocorrect="off" class="form-control input-lg" name="account_number" required>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label>{{ translate(324) }}</label>
                <div class="form-group">
                  <input type="text" autocapitalize="none" autocomplete="nope" autocorrect="off" class="form-control input-lg" name="recipient_address" placeholder="">
                </div>
            </div>
            <div class="col-md-6 pt-m"></div>
        </div>
    </div>

    <div class="form-group">
        <h3 class="admin-heading mb-4">{{ translate(554) }}</h3>
        <div class="row">
            <div class="col-md-6">
                <label class="required-field">{{ translate(318) }}</label>
                <div class="form-group">
                  <input type="text" autocapitalize="none" autocomplete="nope" autocorrect="off" class="form-control input-lg" name="bank_name" placeholder="" required>
                </div>
            </div>
            <div class="col-md-6 pt-m">
                <label>{{ translate(319) }}</label>
                <div class="form-group">
                  <input type="text" autocapitalize="none" autocomplete="nope" autocorrect="off" class="form-control input-lg" name="bank_address" placeholder="">
                </div>
            </div>
        </div>
    </div>

    <x-recipients-currency-field :currencies=$currencies />
</div>