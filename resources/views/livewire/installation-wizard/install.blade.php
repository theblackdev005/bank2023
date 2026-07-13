<div class="d-lg-flex half">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">

                <div class="card shadow-sm">
                    <div class="card-header bg-secondary">
                        <h3 class="text-white d-flex align-items-center m-0" style="line-height: 20px;">
                            <span class="badge d-inline-block badge-info">v{{ app()->version() }}</span>
                            <span class="d-inline-block ml-2">
                                <span>{{ $wizard_title }}</span><br>
                                <small class="font-weight-bold text-warning" style="font-size: 13px;">Progression: {{ $stepPositIndex + 1 }}/{{ count($navigationSteps) }}</small>
                            </span>
                            <div class="ml-auto">
                                <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center" style="height: 60px; width: 60px;">
                                    <div style="padding: 3px;">
                                        <span>{{ round((($stepPositIndex + 1) * 100) / 12) }}<sup>%</sup></span>
                                    </div>
                                </div>
                            </div>
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="wizard-container">

                            {{-- CONTENT --}}
                            @php
                                $w = 'installation-wizard.' . $wizard_step;
                            @endphp
                            <livewire:is :component=$w :wire:key="$w">
                            {{-- CONTENT --}}

                        </div>
                    </div>

                    <div class="card-footer" wire:ignore.self>
                        <div class="d-flex justify-content-between">

                            @if ( $stepPositIndex > 0 )
                                <button type="button" wire:click="goBack" class="btn btn-secondary font-weight-bold">
                                    <i class="fa fa-chevron-left"></i>
                                    <span>Précédent</span>
                                </button>
                            @endif

                            @if ( $stepPositIndex < (count($navigationSteps) - 1) )
                                <button type="button" @disabled($disableNextbtn) wire:click="$emit('checkStepOnChild')" class="btn ml-auto btn-primary font-weight-bold">
                                    <span>Suivant</span>
                                    <i class="fa fa-chevron-right"></i>
                                </button>
                            @else
                                <button type="button" wire:click="finish" class="btn ml-auto btn-warning font-weight-bold">
                                    <i class="fa fa-check-circle"></i>
                                    <span>Terminé</span>
                                </button>
                            @endif

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>