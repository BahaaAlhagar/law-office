@extends('layouts/master')



@section('title')
    {{ $person->name }}
@endsection

@section('content')

      <div id="personProfile">
        <!-- Person info -->
        <div class="card text-center mr-auto">
          <div class="card-header">
          <h4 class="card-title">بيانات الشخص</h4>
          </div>
          <div class="panel-body">
            <table class="table">
              <tbody>
                <tr>
                  <th><strong>الاسم</strong></th>
                  <td>@{{ person.name }}</td>
                </tr>
                <tr>
                  <th><strong>محل الاقامة</strong></th>
                  <td>@{{ person.location }}</td>
                </tr>
                <tr>
                  <th><strong>رقم التليفون</strong></th>
                  <td>@{{ person.phone }}</td>
                </tr>
                <tr>
                  <th><strong>الرقم القومى</strong></th>
                  <td>@{{ person.idenity }}</td>
                </tr>
                <tr>
                  <th><strong>الصفة</strong></th>
                  <td v-if="person.is_client == 1" class="green">موكل</td>
                  <td v-else class="red">ليس موكل</td>
                </tr>
              </tbody>
            </table>
            <div class="mr-auto card-footer">
                <button class="btn btn-info" @click="editPerson(person)">تعديل البيانات</button>
                <button class="btn btn-dark" >عرض الدعاوى</button>
                <button class="btn btn-info" >عرض الاحكام</button>
                <button class="btn btn-primary" >مستندات الشخص</button>
                <button class="btn btn-danger" @click="deletePerson(person)">حذف الشخص</button>
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