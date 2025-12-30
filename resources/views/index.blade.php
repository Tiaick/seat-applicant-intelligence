@extends('web::layouts.app')

@section('title', 'Applicant Intelligence')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Applicant Profiles</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th>Character ID</th>
                            <th>Risk</th>
                            <th>Score</th>
                            <th>Last Updated</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($profiles as $profile)
                            <tr>
                                <td>{{ $profile->character_id }}</td>
                                <td>
                                    @php
                                        $band = $profile->risk_band;
                                        $colors = [
                                            'low' => '#198754',
                                            'medium' => '#ffc107',
                                            'high' => '#dc3545',
                                        ];
                                        $color = $colors[$band] ?? '#6c757d';
                                    @endphp
                                    <span class="align-middle d-inline-flex align-items-center">
                                        <span class="me-2 rounded-circle" style="display:inline-block;width:12px;height:12px;background-color:{{ $color }};"></span>
                                        <span class="text-capitalize">{{ $band }}</span>
                                    </span>
                                </td>
                                <td>{{ $profile->risk_score }}</td>
                                <td>{{ optional($profile->updated_at)->toDateTimeString() }}</td>
                            </tr>
                            @if(!empty($profile->signals['reasons']))
                                <tr>
                                    <td colspan="4" class="border-0 pt-0">
                                        <ul class="mb-3 mt-1 small text-muted">
                                            @foreach($profile->signals['reasons'] as $reason)
                                                <li>{{ $reason }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No applicant profiles found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
