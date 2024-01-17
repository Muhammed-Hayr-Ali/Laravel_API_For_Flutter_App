@extends('admin.layouts.master')
@section('Starter Page', 'Control Panel')
@section('title', 'Messages')
@section('content')


    <div class="px-3">


        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Read Mail</h3>

                <div class="card-tools">
                    {{-- <a href="#" class="btn btn-tool" data-toggle="tooltip" title="Previous"><i class="fas fa-chevron-left"></i></a>
                <a href="#" class="btn btn-tool" data-toggle="tooltip" title="Next"><i class="fas fa-chevron-right"></i></a> --}}
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="mailbox-read-info">
                    <h6>From: {{ $message->name }}
                        <span class="mailbox-read-time float-right">{{ $message->created_at }}</span>
                    </h6>
                </div>
                <!-- /.mailbox-read-info -->
                {{-- <div class="mailbox-controls with-border text-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Delete">
                    <i class="far fa-trash-alt"></i></button>
                  <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Reply">
                    <i class="fas fa-reply"></i></button>
                  <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Forward">
                    <i class="fas fa-share"></i></button>
                </div>
                <!-- /.btn-group -->
                <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Print">
                  <i class="fas fa-print"></i></button>
              </div> --}}
                <!-- /.mailbox-controls -->
                <div class="mailbox-read-message">
                    <p>{{ $message->message }}</p>

                    <!-- /.mailbox-read-message -->
                </div>
                <!-- /.card-body -->

                <!-- /.card-footer -->
                <div class="card-footer">
                    <div class="float-right">
                        <button type="button" class="btn btn-default"><i class="fas fa-reply"></i> Reply</button>
                        <button type="button" class="btn btn-default"><i class="fas fa-share"></i> Forward</button>
                    </div>
                    <button type="button" class="btn btn-default"><i class="far fa-trash-alt"></i> Delete</button>
                    <button type="button" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->

        </div>
    </div>

@endsection

@section('script')

@endsection
