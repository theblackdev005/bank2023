<div class="card mb-4">
    <div class="card-body">
        
        <div class="row">
            <div class="col-12">
                <div class="row d-flex flex-wrap">
                    <div class="col-md-6 d-flex pb-2">
                        <div class="bg-light w-100 rounded py-4 p-3">
                            <table class="table table-bordered m-0 table-sm">
                                <tr>
                                    <td class="font-weight-bold">{{ translate(353) }}</td>
                                    <td>{{ setCurrency($customer->currency, $amount) }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{ translate(342) }}</td>
                                    <td>{{ TEAG }}%</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{ translate(341) }}</td>
                                    <td>{{ $duration }} {{ translate(344) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex pb-2">
                        <div class="bg-light w-100 rounded py-4 p-3">
                            <table class="table table-bordered m-0 table-sm">
                                <tr>
                                    <td class="font-weight-bold">{{ translate(343) }}</td>
                                    <td>{{ setCurrency($customer->currency, $monthlyPayment) }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{ translate(859) }}</td>
                                    <td>{{ setCurrency($customer->currency, $totalPayment) }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{ translate(727) }}</td>
                                    <td>{{ setCurrency($customer->currency, $totalInterest) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <form action="" method="post">
                    @csrf
                    
                    <x-form-input type="number" wiremodel="amount" name="amount" placeholder="" label="{{ translate(353) }}"/>
                    <x-form-input type="number" wiremodel="duration" name="duration" placeholder="" label="{{ translate(354) }}"/>
                    <x-form-textarea wiremodel="goal" name="goal" placeholder="" label="{{ translate(355) }}"/>

                    <div class="form-group">
                        @if ( $readyForm )
                            <button type="submit" class="btn btn-success btn-lg full-m">{{ translate(356) }}</button>
                        @else
                            <button type="button" disabled class="btn btn-success btn-lg full-m">{{ translate(356) }}</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>