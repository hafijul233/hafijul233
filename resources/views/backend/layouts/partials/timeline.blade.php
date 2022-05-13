<!-- The timeline -->
@if(!empty($timeline))
    <div class="timeline timeline-inverse">
    @foreach($timeline as $date => $actions)
        <!-- timeline time label -->
            <div class="time-label">
            <span class="{{ \App\Supports\Utility::randomBadgeBackground() }}">
                {{ date('d M. Y', strtotime($date)) }}
            </span>
            </div>
            <!-- /.timeline-label -->
        @foreach($actions as $action)
            <!-- timeline item -->
                <div>
                    {!! \App\Supports\CHTML::eventIcons($action->event) !!}
                    <div class="timeline-item">
                        <span class="time">
                            <i class="far fa-clock"></i>
                            {{ \Carbon\Carbon::parse($action->created_at)->format('h:i a')  }}
                        </span>
                        <h3 class="timeline-header">
                            <a href="{{ route('backend.settings.users.show', ($action->user->id ?? 1)) }}">
                                {{ $action->user->name ?? 'System' }}</a> {{ ucwords($action->event) }} this
                            {{ strtolower(class_basename($action->auditable_type)) }}
                        </h3>

                        <div class="timeline-body">
                            <table class="table table-striped table-bordered">
                                <tbody>
                                <tr>
                                    <td>
                                        IP Address
                                    </td>
                                    <td>
                                        {{ $action->ip_address }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        User Agent
                                    </td>
                                    <td>
                                        {{ $action->user_agent }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Old Value
                                    </td>
                                    <td>
                                        @dump($action->old_values)
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        New Value
                                    </td>
                                    <td>
                                        @dump($action->new_values)
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END timeline item -->
            @endforeach
        @endforeach
        <div>
            <i class="far fa-clock bg-gray"></i>
        </div>
    </div>
@else
    <h1 class="text-center">No Event Record</h1>
@endif
