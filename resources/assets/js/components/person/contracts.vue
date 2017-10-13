<template>
    <div v-if="contracts.length" class="card text-center mr-auto">
          <div class="card-header">
          <h4 class="card-title">بيانات التوكيلات</h4>
          </div>
          <div class="panel-body">
            <table class="table table-responsive">
              <tbody>
                <tr v-for="contract in contracts">
                  <td>
                    <a :href="/contracts/ + contract.id">{{ contract.number }} لسنة {{ contract.year }} <br> حرف {{ contract.letter }} </a>
                  </td>
                  <td v-if="contract.type == 1" class="brown">توكيل عام</td>
                  <td v-if="contract.type == 2" class="blue">توكيل خاص</td>
                  <td v-if="contract.type == 3" class="green">عقد وكالة</td>
                  <td>{{ contract.office }}</td>
                </tr>
              </tbody>
            </table>
          </div>
    </div>
</template>
<script>
      export default {
        props: ['contracts']
      }
</script>