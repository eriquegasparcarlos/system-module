<template>
    <el-dialog :title="titleDialog" :visible="showDialog" @close="clickClose" @open="handleOpen" class="dialog-small" :close-on-click-modal="false">
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
    </el-dialog>
</template>

<script>
    export default {
        props: ['showDialog', 'record'],
        data() {
            return {
                titleDialog: null,
                loading: false,
                resource: 'summaries',
            }
        },
        created() {
        },
        methods: {
            handleOpen() {
                this.loading = true
                this.titleDialog = 'Resumen'
                this.loading = false
            },
            clickDownload(download) {
                window.open(download, '_blank');
            },
            clickClose() {
                this.$emit('update:showDialog', false)
            },
        }
    }
</script>
