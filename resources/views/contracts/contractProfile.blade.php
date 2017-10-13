@extends('layouts/master')



@section('title')
    التوكيل رقم {{ $contract->number }} لسنة {{ $contract->year }}
@endsection

@section('css')
    <link href="{{ URL::asset('css/toastr.min.css') }}" rel="stylesheet">
@endsection


@section('content')

      <div id="contractProfile">
        <!-- contract info -->
        <div class="card text-center mr-auto">
          <div class="card-header">
          <h4 class="card-title">بيانات التوكيل</h4>
          </div>
          <div class="panel-body">
            <table class="table table-responsive">
              <tbody>
                <tr>
                  <th><strong>الرقم</strong></th>
                  <td>@{{ contract.number }}</td>
                </tr>
                <tr>
                  <th><strong>سنة التوكيل</strong></th>
                  <td>@{{ contract.year }}</td>
                </tr>
                <tr>
                  <th><strong>حرف السجل - رقم السجل</strong></th>
                  <td>@{{ contract.letter }}</td>
                </tr>
                <tr>
                  <th><strong>مكتب الاصدار</strong></th>
                  <td>@{{ contract.office }}</td>
                </tr>
                <tr>
                <th><strong>نوع التوكيل</strong></th>
                  <td v-if="contract.type == 1" class="brown">توكيل عام</td>
                  <td v-if="contract.type == 2" class="blue">توكيل خاص</td>
                  <td v-if="contract.type == 3" class="green">عقد وكالة</td>
                </tr>
                <tr>
                  <th><strong>رقم التوكيل بفهرس الحفظ</strong></th>
                  <td>@{{ contract.archive_number }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        
        <div class="card text-center mr-auto">
          <div class="card-header">
          <h4 class="card-title">بيانات الموكلين</h4>
          </div>
          <div class="panel-body">
            <table class="table table-responsive">
              <tbody>
                <tr v-for="person in contract.people">
                  <td><a :href="/people/ + person.id">@{{ person.name }}</a></td>
                  <td>@{{ person.location }}</td>
                </tr>
              </tbody>
            </table>
            <div class="mr-auto card-footer">
                <button class="btn btn-info" @click="editContract(contract)">تعديل البيانات</button>
                <button class="btn btn-danger" @click="deleteContract(contract)">حذف التوكيل</button>
            </div>
          </div>
        </div>


        <edit-contract :people="people"></edit-contract>
      </div>
@endsection


@section('js')

<script src="{{ URL::asset('js/contractProfile.js') }}"></script>
@endsection