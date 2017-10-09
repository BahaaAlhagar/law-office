@extends('layouts/master')



@section('title')
    الملفات - {{ $person->name }}
@endsection

@section('css')
    <link href="{{ URL::asset('css/toastr.min.css') }}" rel="stylesheet">
@endsection

@section('content')

      <div id="personFiles">
        <!-- Person info -->
        <div class="card text-center mr-auto">
          <div class="card-header">
          <h4 class="card-title">ادارة ملفات - {{ $person->name }}</h4>
          </div>
          <div class="panel-body">
            <table class="table table-striped table-bordered table-responsive">
              <thead class="thead-inverse">
                <tr>
                  <th float="right">
                  اســـم الـمــستند
                  </th>
                  <th>
                  حــجـــمه - امتداده
                  </th>
                  <th>
                  استعراض وتحميل
                  </th>
                  <th>
                  الاعدادات
                  </th>
                </tr>
            </thead>
            <tbody>

                @foreach ($person->files as $file)
                <tr>
                  <td>
                  {{ $file->name }}
                  </td>
                  <td>{{ $file->size }} kb</td>
                  <td>
                  <a target="_blank" href="{{ URL::asset('storage/Clients/'.$Client->id.'/'.$file->link) }}" target="_blank">
                    <button><i class="fa fa-download" aria-hidden="true"></i></button>
                  </a>
                  </td>
                  <td>
                    <a href="/file/{{ $file->id }}/delete">
                      <button class="btn btn-danger btn-sm delete-file" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>
                      </a> 
                  </td>
                </tr>
                @endforeach
                

            </tbody>
            </table>
            <div class="mr-auto card-footer">
                <button class="btn btn-info" @click="editFile(file)">تعديل بيانات الملف</button>
                <button class="btn btn-danger" @click="deleteFile(file)">حذف الملف</button>
            </div>
          </div>
        </div>
        

        <contracts :contracts="contracts"></contracts>

        <edit-person></edit-person>
      </div>
@endsection


@section('js')

<script src="{{ URL::asset('js/personProfile.js') }}"></script>
@endsection