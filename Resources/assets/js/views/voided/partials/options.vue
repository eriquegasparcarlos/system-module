<template>
    <el-dialog :title="titleDialog" :visible="showDialog" @close="clickClose" @open="handleOpen" class="dialog-small" :close-on-click-modal="false">
    <!--<el-dialog :title="titleDialog" :visible="showDialog" @open="create" width="30%" :close-on-click-modal="false" :close-on-press-escape="false" :show-close="false">-->
        <div class="row" v-loading="loading">
            <div class="col-12">
                <table class="table no-border table-document-information">
                    <tbody>
                    <tr>
                        <td>Estado</td>
                        <td class="font-medium" :class="{'text-danger': record.state_type_id === '09'}">{{ record.state_type_description }}</td>
                    </tr>
                    <tr>
                        <td>Código externo</td>
                        <td class="font-medium">{{ record.external_id }}</td>
                    </tr>
                    <!--<tr>-->
                        <!--<td>Hash</td>-->
                        <!--<td class="font-medium">{{ record.hash }}</td>-->
                    <!--</tr>-->
                    <tr>
                        <td>Fecha de emisión</td>
                        <td class="font-medium">{{ record.date_of_issue }}</td>
                    </tr>
                    <tr>
                        <td>Fecha de referencia</td>
                        <td class="font-medium">{{ record.date_of_reference }}</td>
                    </tr>
                    <tr v-if="record.response_code">
                        <td>Response code</td>
                        <td class="font-medium">{{ record.response_code }}</td>
                    </tr>
                    <tr v-if="record.response_description">
                        <td>Response description</td>
                        <td class="font-medium">{{ record.response_description }}</td>
                    </tr>
                    <tr v-if="record.external_id">
                        <td>Descargas</td>
                        <td><el-button size="mini" @click.prevent="clickDownload(record.download_xml)">XML</el-button>
                            <el-button size="mini" @click.prevent="clickDownload(record.download_cdr)" v-if="record.btn_cdr">CDR</el-button></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-12">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Número</th>
                        <th class="text-center">Fecha</th>
                        <th class="text-right">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="document in record.documents">
                        <td>{{ document.number }}</td>
                        <td class="text-center">{{ document.date_of_issue }}</td>
                        <td class="text-right">{{ document.total }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!--<div class="row mt-4">-->
            <!--<div class="col-md-5">Estado</div>-->
            <!--<div class="col-md-7">{{ form.state_type_description }}</div>-->
        <!--</div>-->
        <!--<div class="row mt-4">-->
            <!--<div class="col-md-5">Fecha de emisión</div>-->
            <!--<div class="col-md-7">{{ form.date_of_issue }}</div>-->
        <!--</div>-->
        <!--<div class="row">-->
            <!--<div class="col-12 text-right">-->
                <!--<el-button @click.prevent="clickClose">Cerrar</el-button>-->
                <!--&lt;!&ndash;<el-button type="primary" @click="clickPaymentCard">Agregar Pago</el-button>&ndash;&gt;-->
            <!--</div>-->
        <!--</div>-->
        <!--<span slot="footer" class="dialog-footer">-->
            <!--&lt;!&ndash;<template v-if="showClose">&ndash;&gt;-->
                <!--<el-button @click="clickClose">Cerrar</el-button>-->
            <!--&lt;!&ndash;</template>&ndash;&gt;-->
            <!--&lt;!&ndash;<template v-else>&ndash;&gt;-->
                <!--&lt;!&ndash;<el-button class="list" @click="clickFinalize">Ir al listado</el-button>&ndash;&gt;-->
                <!--&lt;!&ndash;<el-button type="primary" @click="clickNewDocument">Nuevo comprobante</el-button>&ndash;&gt;-->
            <!--&lt;!&ndash;</template>&ndash;&gt;-->
        <!--</span>-->
    </el-dialog>
</template>

<script>
    export default {
//        props: ['showDialog', 'recordId'],
        props: ['showDialog', 'record'],
        data() {
            return {
                titleDialog: null,
                loading: false,
                resource: 'voided',
//                errors: {},
//                form: {},
//                company: {}
            }
        },
        created() {
//            this.initForm()
//            await this.$http.get(`/companies/record`)
//                .then(response => {
//                    if (response.data !== '') {
//                        this.company = response.data.data
//                    }
//                })
        },
        methods: {
//            initForm() {
//                this.titleDialog = null
//                this.errors = {}
//                this.form = {}
//            },
            handleOpen() {
                this.loading = true
//                this.initForm()
//                this.form = this.record//response.data.data
                this.titleDialog = 'Anulación'//' 'Comprobante: '+this.record.number
//                await this.$http.get(`/${this.resource}/record/${this.recordId}`).then(response => {
//                    this.form = response.data.data
//                    this.titleDialog = 'Comprobante: '+this.form.number
//                });
                this.loading = false
            },
//            clickPrint(format){
//                window.open(`/print/document/${this.form.external_id}/${format}`, '_blank');
//            },
//            clickDownload() {
//                window.open(`${this.record.download_pdf}`, '_blank');
//            },
            clickDownload(download) {
                window.open(download, '_blank');
            },
//            clickSendEmail() {
//                this.loading = true
//                this.$http.post(`/${this.resource}/email`, {
//                    customer_email: this.record.customer_email,
//                    id: this.record.id
//                })
//                    .then(response => {
//                        if (response.data.success) {
//                            this.$message.success('El correo fue enviado satisfactoriamente')
//                        } else {
//                            this.$message.error('Error al enviar el correo')
//                        }
//                    })
//                    .catch(error => {
//                        if (error.response.status === 422) {
//                            this.errors = error.response.data.errors
//                        } else {
//                            this.$message.error(error.response.data.message)
//                        }
//                    })
//                    .then(() => {
//                        this.loading = false
//                    })
//            },
//            clickConsultCdr(document_id) {
//                this.$http.get(`/${this.resource}/consult_cdr/${document_id}`)
//                    .then(response => {
//                        if (response.data.success) {
//                            this.$message.success(response.data.message)
//                            this.$eventHub.$emit('reloadData')
//                        } else {
//                            this.$message.error(response.data.message)
//                        }
//                    })
//                    .catch(error => {
//                        this.$message.error(error.response.data.message)
//                    })
//            },
//            clickFinalize() {
//                location.href = `/${this.resource}`
//            },
//            clickNewDocument() {
//                this.clickClose()
//            },
            clickClose() {
                this.$emit('update:showDialog', false)
//                this.initForm()
            },
        }
    }
</script>
