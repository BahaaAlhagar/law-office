@extends('layouts/master')

@section('meta')
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

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
          <h4 class="card-title">
              ادارة ملفات - 
              <a :href="'/people/' + person.id">
                @{{ person.name }}
              </a>
              <button class="btn pull-left btn-dark" data-toggle="modal" data-target="#fileUploader">اضافة ملف</button>
          </h4>
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
                <tr v-for="file in files">
                  <td>
                      @{{ file.name }}
                  </td>
                  <td>
                      @{{ file.size }} kb <br>
                      @{{ file.type }}
                  </td>
                  <td>
                      <a target="_blank" :href="'/storage/people/' + person.id + '/' + file.link" target="_blank">
                        <button><i class="fa fa-download" aria-hidden="true"></i></button>
                      </a>
                  </td>
                  <td>
                      <button class="btn btn-info" @click="editFile(file)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                      <button class="btn btn-danger" @click="deleteFile(file)"><i class="fa fa-times" aria-hidden="true"></i></button>
                  </td>
                </tr>
            </tbody>
            </table>
            <v-paginator class="heading" v-if="files.length" :options="options" ref="VP"  :resource_url="resource_url" @update="updateResource"></v-paginator>
          </div>
        </div>
        
        <file-uploader></fileUploader>

      </div>
@endsection


@section('js')

<script src="{{ URL::asset('js/personFiles.js') }}"></script>
@endsection