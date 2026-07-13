<div class="card">
    <div class="card-body">
        <div class="row"> 
            <div class="col-md-8">
                
                <div class="row">
                    <div class="col-md-12">
                        <p class="text-left">
                            <b>{{ translate(546) }}</b>
                        </p>
                    </div>
                </div>

                @php
                    $total = 0;
                    $checkCount = ($init === 'yes') ? 0 : $pending_transfert->fees()->count();
                @endphp

                <div class="row py-2 fees-listing">
                    <div class="col-md-11 offset-md-1">
                        <table class="w-100 table-striped">
                            
                            @if ($checkCount > 0)
                                
                                @foreach ($pending_transfert->paidFees()->get() as $fee)
                                    <tr>
                                        <td class="px-2">
                                            <i data-toggle="tooltip" data-placement="top" title="{{ $fee->percentage }}%" class="fa fa-check-circle text-success"></i>
                                        </td>
                                        <td class="px-2 text-small" style="width: 50%">{{ $fee->name }}</td>
                                        <td class="text-bold">{{ setCurrency($fee->currency, $fee->cost) }}</td>
                                    </tr>
                                    @php
                                        $total += $fee->cost;
                                    @endphp
                                @endforeach
                                
                                @if ($showNextPendingFee == 'yes')
                                    @if ($fee = $pending_transfert->currentPendingFee())
                                        @php
                                            $total += $fee->cost;
                                        @endphp
                                        <tr>
                                            <td class="px-2">
                                                <i data-toggle="tooltip" data-placement="top" title="{{ $fee->percentage }}%" class="fa fa-spinner text-warning"></i>
                                            </td>
                                            <td class="px-2 text-small" style="width: 50%">{{ $fee->name }}</td>
                                            <td class="text-bold">{{ setCurrency($fee->currency, $fee->cost) }}</td>
                                        </tr>
                                    @endif
                                @endif
                            @else
                                <tr>
                                    <td class="text-center">{{ translate(661) }}</td>
                                </tr>
                            @endif
                            
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <p class="text-left">
                            <b>{{ translate(548) }}</b>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <div class="text-right">
                            <span class="float-right">
                                @if ($total > 0)
                                    {{ setCurrency($pending_transfert->currency, $total) }}
                                @else
                                    <strong class="points"></strong>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-4">
                <div class="mx-auto">

                    @if ( $init === 'yes' )
                        <div id="svg__loader">
                            <div class="m-auto svg__loader__container">
                                <img src="{{ asset('assets/banking/images/animated_spinner.gif') }}" alt="">
                            </div>
                        </div>
                    @else
                        <div wire:ignore id="loader" data-percentage="{{ $percentage }}"></div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>