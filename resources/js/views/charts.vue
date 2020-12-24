<template>
    <div class="row">
        <div class="col-md-6 ">
            <CRow>
                <CCol>
                    <CCard>
                        <CCardHeader>
                            Gender
                        </CCardHeader>
                        <CCardBody>
                            <CChartPie :datasets="defaultDatasets"
                                       :labels="['Male', 'Female']" />
                        </CCardBody>
                        <CCardFooter>
                            .
                        </CCardFooter>
                    </CCard>
                </CCol>

            </CRow>
        </div>

        <div class="col-md-6 ">
            <CRow>
                <CCol>
                    <CCard>
                        <CCardHeader>
                            Gender
                        </CCardHeader>
                        <CCardBody>
                            <div class="card border-warning mb-3" style="max-width: 18rem;">
                                <div class="card-header">Header</div>
                                <div class="card-body text-warning">
                                    <h5 class="card-title">Users</h5>
                                    <p class="card-text"> {{counter}}</p>
                                </div>
                            </div>

                        </CCardBody>
                        <CCardFooter>
                            .
                        </CCardFooter>
                    </CCard>
                </CCol>

            </CRow>
        </div>
    </div>
    
</template>

<script>
import { CChartPie } from '@coreui/vue-chartjs'

export default {
  name: 'CChartPieExample',
  components: { CChartPie },
        data() {
            return {
                male: '',
                female:'',
                counter:''
            }

        },
        mounted() {
            this.loadData();
        },
        methods: {
            loadData: function () {
                axios.get('http://127.0.0.1:8000/api/counter').then(res => {
                    if (res.status == 200) {
                        this.male = res.data.male;
                        this.female = res.data.female;
                        this.counter = res.data.user;
                    }
                }).catch(err => {
                    console.log(err)
                });
            }
        },
  computed: {
    defaultDatasets () {
      return [
        {
          backgroundColor: [
            '#41B883',
            '#E46651',
           
          ],
              data: [this.female, this.male ]
        }
      ]
    }
  }
}
</script>
