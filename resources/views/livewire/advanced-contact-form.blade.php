<form class="mt-2 form-style-020 form-need-validation" method="post" action="">
    @csrf
    
    @if ( isset($accountCustomer) && ($accountCustomer === false) )

        <x-alert success="true" />

        <div class="row">
            <div class="col-md-6">
                <x-form-input label="{{ translate(256) }}" placeholder="" name="name"/>
            </div>
            <div class="col-md-6">
                <x-form-input type="email" label="{{ translate(257) }}" placeholder="" name="email"/>
            </div>
        </div>
        
        <div class="bg-light p-2 px-4 rounded border mb-2">
            <div class="form-group">
                <div>
                    <h5 class="text-danger">{{ translate(823) }}</h5>
                </div>
                <label for="customer_care" class="mr-2 d-inline-block text-muted">
                    <input wire:model="department" type="radio" value="customer_care" id="customer_care"> {{ translate(824) }}
                </label>
                <label wire:click="retreiveManagers" class="d-inline-block text-muted" for="choose_manager">
                    <input wire:model="department" type="radio" value="manager" id="choose_manager"> {{ translate(825) }}
                </label>
            </div>

            @if ( $department == 'manager' )
                <div class="form-group">
                    <label class="form-label">{{ translate(821) }}</label>
                    <select class="form-control" name="account_manager" required>
                        <option value=""></option>
                        @foreach ($admins as $admin)
                            <option value="{{ $admin->id }}" @selected_if($admin->id == old('account_manager'))>{{ ! is_null($admin->name) ? $admin->name : $admin->email }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>

    @else
        <input type="hidden" name="name" value="{{ $accountCustomer->fullname() }}">
        <input type="hidden" name="email" value="{{ $accountCustomer->email }}">
        <input type="hidden" name="account_manager" value="{{ $accountCustomer->admin->id }}">
    @endif

    <x-form-input label="{{ translate(258) }}" placeholder="" name="subject"/>
    <x-form-textarea label="{{ translate(259) }}" placeholder="" name="message"/>

    <div class="mb-2">
        <x-recaptcha></x-recaptcha>
    </div>

    <div  class="row">
        <div class="col-md-12">
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-block">{{ translate(260) }}</button>
            </div>
        </div>
    </div>
</form>