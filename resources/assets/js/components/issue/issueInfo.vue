<template>
        <div class="card text-center mr-auto">
          <div class="card-header">
          <h4 class="card-title">
          »Ì«‰«  «·ﬁ÷Ì…
          <span></span>
          <button class="btn pull-left btn-dark" @click="printPage">ÿ»«⁄… «·’›Õ…</button>
          </h4>
          </div>
          <div class="panel-body">
            <table class="table table-striped table-bordered">
              <button style="margin-left: 15px;" id="print-normal" class="pull-left btn btn-success printButton" onclick="printN();">ÿ»«⁄… «·’›Õ…</button>
                <tbody>
                  <tr>
                    <td>„Ê÷‹‹‹‹Ê⁄ «·œ⁄‹‹‹ÊÏ</td>
                    <td>{{ $Issue->subject }}</td>
                  </tr>
                  <tr>
                    <td>—ﬁ„ «·œ⁄‹‹‹ÊÏ</td>
                    <td>@if (! is_null($Issue->number)) {{ $Issue->number }} ·”‰… {{ $Issue->year }} {{ \App\Issue::issuetype($Issue) }} @endif</td>
                  </tr>
                  <tr>
                    <td>—ﬁ„ «·√” ∆‹‹‹‰«›</td>
                    <td>@if (! is_null($Issue->adv_number)) {{ $Issue->adv_number }} ·”‰… {{ $Issue->adv_year }} ”@endif</td>
                  </tr>
                  <tr>
                    <td>«·„Õﬂ„…</td>
                    <td>@if (! is_null($Issue->court)) {{ $Issue->court }}@endif
                      @if (! is_null('$Issue->room')) - «·œ«∆‹‹—… {{ $Issue->room }}@endif
                    </td>
                  </tr>
                </tbody>
              </table>
            <div class="mr-auto card-footer">
                <button class="btn btn-info" @click="editPerson(person)"> ⁄œÌ· «·»Ì«‰« </button>
                <button class="btn btn-danger" @click="deletePerson(person)">Õ–› «·‘Œ’</button>
            </div>
          </div>
        </div>
</template>