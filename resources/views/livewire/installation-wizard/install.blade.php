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
                                        <span>{{ round((($stepPositIndex + 1) * 100) / count($navigationSteps)) }}<sup>%</sup></span>
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

                            @if ($finishError)
                                <div class="alert alert-danger mt-3 mb-0">{{ $finishError }}</div>
                            @endif

                            @if ( $stepPositIndex === (count($navigationSteps) - 1) )
                                <div class="mt-4 p-3 border bg-light">
                                    <h5 class="font-weight-bold mb-3">Résumé avant mise en ligne</h5>
                                    @foreach ($this->installationSummary() as $label => $status)
                                        <div class="d-flex justify-content-between border-bottom py-1">
                                            <span>{{ $label }}</span>
                                            <strong>{{ $status }}</strong>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

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

                            @if ( in_array($wizard_step, $optionalSteps, true) && $stepPositIndex < (count($navigationSteps) - 1) )
                                <button type="button" wire:click="skipStep" class="btn ml-auto btn-light border font-weight-bold">
                                    <span>Passer</span>
                                </button>
                            @endif

                            @if ( $stepPositIndex < (count($navigationSteps) - 1) )
                                <button type="button" @disabled($disableNextbtn) wire:click="$emit('checkStepOnChild')" class="btn {{ in_array($wizard_step, $optionalSteps, true) ? 'ml-2' : 'ml-auto' }} btn-primary font-weight-bold">
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
