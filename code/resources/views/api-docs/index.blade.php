@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-code me-2"></i>{{ __('API Documentation') }}
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5>{{ __('Scientific Research Laboratory Management System API') }}</h5>
                            <p class="text-muted">{{ __('RESTful API for managing laboratory resources, research projects, and academic collaborations.') }}</p>

                            <h6 class="mt-4">{{ __('Base URL') }}</h6>
                            <code>{{ config('app.url') }}/api</code>

                            <h6 class="mt-4">{{ __('Authentication') }}</h6>
                            <p>{{ __('All API requests require authentication using Bearer tokens.') }}</p>

                            <h6 class="mt-4">{{ __('Available Endpoints') }}</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>{{ __('Method') }}</th>
                                            <th>{{ __('Endpoint') }}</th>
                                            <th>{{ __('Description') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><span class="badge bg-success">GET</span></td>
                                            <td><code>/api/researchers</code></td>
                                            <td>{{ __('List all researchers') }}</td>
                                        </tr>
                                        <tr>
                                            <td><span class="badge bg-primary">POST</span></td>
                                            <td><code>/api/researchers</code></td>
                                            <td>{{ __('Create new researcher') }}</td>
                                        </tr>
                                        <tr>
                                            <td><span class="badge bg-success">GET</span></td>
                                            <td><code>/api/projects</code></td>
                                            <td>{{ __('List all projects') }}</td>
                                        </tr>
                                        <tr>
                                            <td><span class="badge bg-primary">POST</span></td>
                                            <td><code>/api/projects</code></td>
                                            <td>{{ __('Create new project') }}</td>
                                        </tr>
                                        <tr>
                                            <td><span class="badge bg-success">GET</span></td>
                                            <td><code>/api/publications</code></td>
                                            <td>{{ __('List all publications') }}</td>
                                        </tr>
                                        <tr>
                                            <td><span class="badge bg-primary">POST</span></td>
                                            <td><code>/api/publications</code></td>
                                            <td>{{ __('Create new publication') }}</td>
                                        </tr>
                                        <tr>
                                            <td><span class="badge bg-success">GET</span></td>
                                            <td><code>/api/equipment</code></td>
                                            <td>{{ __('List all equipment') }}</td>
                                        </tr>
                                        <tr>
                                            <td><span class="badge bg-warning">PUT</span></td>
                                            <td><code>/api/equipment/{id}/reserve</code></td>
                                            <td>{{ __('Reserve equipment') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6>{{ __('Quick Start') }}</h6>
                                    <p class="small">{{ __('Get your API token from your profile settings and include it in requests:') }}</p>
                                    <pre class="small"><code>Authorization: Bearer YOUR_TOKEN</code></pre>

                                    <h6 class="mt-3">{{ __('Example Request') }}</h6>
                                    <pre class="small"><code>curl -X GET {{ config('app.url') }}/api/researchers \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json"</code></pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection