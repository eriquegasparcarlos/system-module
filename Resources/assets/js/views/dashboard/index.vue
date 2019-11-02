<template>
    <div class="row page-dashboard">
        <!--<div class="col-lg-3">-->
            <!--<div class="card">-->
                <!--<div class="card-body">-->
                    <!--<div class="d-flex no-block">-->
                        <!--<div class="m-r-20 align-self-center">-->
                            <!--<i class="mdi mdi-file-document-box-multiple-outline mdi-card"></i>-->
                            <!--&lt;!&ndash;<img src="../assets/images/icon/income.png" alt="Income">&ndash;&gt;-->
                        <!--</div>-->
                        <!--<div class="align-self-center">-->
                            <!--<h6 class="text-muted m-t-10 m-b-0">Total Documentos</h6>-->
                            <!--<h2 class="m-t-0">{{ all_data.total_documents }}</h2></div>-->
                    <!--</div>-->
                    <!--<table class="table no-border m-t-30">-->
                        <!--<tbody>-->
                        <!--<tr v-for="row in all_data.group_documents">-->
                            <!--<td>{{ row.document_type_description }}</td>-->
                            <!--<td class="text-right">{{ row.total_documents }}</td>-->
                        <!--</tr>-->
                        <!--</tbody>-->
                    <!--</table>-->
                <!--</div>-->
            <!--</div>-->
        <!--</div>-->
        <!--<div class="col-lg-3">-->
            <!--<div class="card">-->
                <!--<div class="card-body">-->
                    <!--<div class="d-flex no-block">-->
                        <!--<div class="m-r-20 align-self-center"><span class="lstick m-r-20"></span>-->
                            <!--&lt;!&ndash;<img src="../assets/images/icon/expense.png" alt="Income">&ndash;&gt;-->
                        <!--</div>-->
                        <!--<div class="align-self-center">-->
                            <!--<h6 class="text-muted m-t-10 m-b-0">Total Expense</h6>-->
                            <!--<h2 class="m-t-0">236,000</h2></div>-->
                    <!--</div>-->
                <!--</div>-->
            <!--</div>-->
        <!--</div>-->
        <!--<div class="col-lg-3">-->
            <!--<div class="card">-->
                <!--<div class="card-body">-->
                    <!--<div class="d-flex no-block">-->
                        <!--<div class="m-r-20 align-self-center"><span class="lstick m-r-20"></span>-->
                            <!--&lt;!&ndash;<img src="../assets/images/icon/assets.png" alt="Income">&ndash;&gt;-->
                        <!--</div>-->
                        <!--<div class="align-self-center">-->
                            <!--<h6 class="text-muted m-t-10 m-b-0">Total Assets</h6>-->
                            <!--<h2 class="m-t-0">987,563</h2></div>-->
                    <!--</div>-->
                <!--</div>-->
            <!--</div>-->
        <!--</div>-->
        <!--<div class="col-lg-3">-->
            <!--<div class="card">-->
                <!--<div class="card-body">-->
                    <!--<div class="d-flex no-block">-->
                        <!--<div class="m-r-20 align-self-center"><span class="lstick m-r-20"></span>-->
                            <!--&lt;!&ndash;<img src="../assets/images/icon/staff.png" alt="Income">&ndash;&gt;-->
                        <!--</div>-->
                        <!--<div class="align-self-center">-->
                            <!--<h6 class="text-muted m-t-10 m-b-0">Total - Staff</h6>-->
                            <!--<h2 class="m-t-0">987,563</h2></div>-->
                    <!--</div>-->
                <!--</div>-->
            <!--</div>-->
        <!--</div>-->
    </div>
</template>

<script>

    export default {
        data() {
            return {
//                showDialogVoided: false,
//                showDialogOptions: false,
//                resource: 'dashboard',
////                recordId: null,
//                all_data: {
//                    total_documents: 0,
//                    group_documents: []
//                }
            }
        },
//        async created() {
//            await this.$http.get(`/${this.resource}/data`)
//                .then(response => {
//                    this.all_data.total_documents = response.data.total_documents
//                    this.all_data.group_documents = response.data.group_documents
////                    this.currency_types = response.data.currency_types
////                    this.establishments = response.data.establishments
////                    this.all_customers = response.data.customers
////                    this.payment_condition_types = response.data.payment_condition_types
////                    this.payment_method_types = response.data.payment_method_types
////                    this.card_brands = response.data.card_brands
//
////                    this.resetForm()
//                })
//        },
        methods: {

        }
    }
</script>
