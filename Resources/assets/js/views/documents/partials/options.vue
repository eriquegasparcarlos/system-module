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
                    <tr>
                        <td>Hash</td>
                        <td class="font-medium">{{ record.hash }}</td>
                    </tr>
                    <tr>
                        <td>Fecha de emisión</td>
                        <td class="font-medium">{{ record.date_of_issue }}</td>
                    </tr>
                    <tr v-if="record.response_code">
                        <td>Response code</td>
                        <td class="font-medium">{{ record.response_code }}</td>
                    </tr>
                    <tr v-if="record.response_description">
                        <td>Response description</td>
                        <td class="font-medium">{{ record.response_description }}</td>
                    </tr>
                    <tr>
                        <td>Descargas</td>
                        <td>
                            <el-button size="mini" @click.prevent="clickDownload(record.download_xml)">XML</el-button>
                            <el-button size="mini" @click.prevent="clickDownload(record.download_pdf)">PDF</el-button>
                            <el-button size="mini" @click.prevent="clickDownload(record.download_cdr)" v-if="record.btn_cdr">CDR</el-button>
                        </td>
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
                resource: 'documents',
            }
        },
        created() {
        },
        methods: {
            handleOpen() {
                this.loading = true
                this.titleDialog = 'Comprobante: '+this.record.number
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
