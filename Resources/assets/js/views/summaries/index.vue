<template>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-title">
                    <span class="lstick"></span>
                    <div>
                        <h4>{{ title }}</h4>
                    </div>
                    <div>
                        <el-select v-model="clientId" @change="changeClientId">
                            <el-option v-for="option in clients" :key="option.id" :value="option.id" :label="option.description"></el-option>
                        </el-select>
                    </div>
                </div>
                <div class="card-body" v-loading="loading">
                    <template v-if="clientId">
                        <div class="row" v-if="records.length > 0">
                            <div class="col-md-12 mb-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <x-form-group label="Tipo de documento">
                                            <el-select v-model="filter.document_type_id">
                                                <el-option key="all" value="all" label="Todos"></el-option>
                                                <el-option v-for="(option, index) in document_types" :key="index" :value="index" :label="option"></el-option>
                                            </el-select>
                                        </x-form-group>
                                    </div>
                                    <div class="col-md-4">
                                        <x-form-group label="Tipo de estado">
                                            <el-select v-model="filter.state_type_id">
                                                <el-option key="all" value="all" label="Todos"></el-option>
                                                <el-option v-for="(option, index) in state_types" :key="index" :value="index" :label="option"></el-option>
                                            </el-select>
                                        </x-form-group>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Entorno</th>
                                            <th class="text-center">Fecha Emisión</th>
                                            <th class="text-center">Fecha Referencia</th>
                                            <th class="text-center">Identificador</th>
                                            <th class="text-center">Ticket</th>
                                            <th>Estado</th>
                                            <th>Tipo</th>
                                            <th class="text-right">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(row, index) in records">
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ row.soap_type_description }}</td>
                                            <td class="text-center">{{ row.date_of_issue }}</td>
                                            <td class="text-center">{{ row.date_of_reference }}</td>
                                            <td class="text-center">{{ row.identifier }}</td>
                                            <td class="text-center">{{ row.ticket }}</td>
                                            <td>{{ row.state_type_description }}</td>
                                            <td>{{ row.summary_status_type_description }}</td>
                                            <td class="text-right button-actions">
                                                <el-button size="mini" icon="el-icon-position"
                                                           @click.prevent="clickSend(row)"
                                                           v-if="row.btn_send"
                                                           :loading="row.loading">
                                                    <template v-if="row.loading">
                                                        Enviando...
                                                    </template>
                                                    <template v-else>
                                                        Enviar
                                                    </template>
                                                </el-button>
                                                <el-button size="mini" icon="el-icon-check"
                                                           @click.prevent="clickValidate(row)"
                                                           v-if="row.btn_validate"
                                                           :loading="row.loading">
                                                    <template v-if="row.loading">
                                                        Validando...
                                                    </template>
                                                    <template v-else>
                                                        Validar
                                                    </template>
                                                </el-button>
                                                <el-button size="mini" icon="el-icon-more-outline" @click.prevent="clickOptions(row)"></el-button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row" v-else>
                            <div class="col-md-12">
                                <div class="alert alert-info m-0">No se encontraron resultados.</div>
                            </div>
                        </div>
                    </template>
                    <template v-else>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-info m-0">Seleccionar cliente.</div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        <summary-options :showDialog.sync="showDialogOptions"
                         :record="record"></summary-options>
    </div>
</template>

<script>

    import SummaryOptions from './partials/options.vue'

    export default {
        components: {SummaryOptions},
        data() {
            return {
                loading: false,
                showDialog: false,
                showDialogOptions: false,
                resource: 'summaries',
                clients: [],
                clientId: null,
                records: [],
                record: {},
                document_types: [],
                state_types: [],
                filter: {
                    document_type_id: 'all',
                    state_type_id: 'all',
                },
            }
        },
       async created() {
            this.loading = true;
            this.title = 'Resúmenes';
            await this.$http.get(`/${this.resource}/tables`)
                .then(response => {
                    this.clients = response.data.clients
                    this.document_types = response.data.document_types
                    this.state_types = response.data.state_types
                });
           this.loading = false;
       },
        methods: {
            async changeClientId() {
                this.loading = true;
                this.records = [];
                await this.$http.get(`/${this.resource}/records/${this.clientId}`)
                    .then(response => {
                        this.records = response.data.data;
                    });
                this.loading = false;
            },
            clickOptions(record) {
                this.record = record;
                this.showDialogOptions = true;
            },
            clickSend(row) {
                row.loading = true;
                this.$http.post(`/${this.resource}/send`, {
                    'client_id': this.clientId,
                    'external_id': row.external_id
                })
                    .then(response => {
                        if (response.data.success) {
                            this.$message.success(response.data.message);
                        } else {
                            this.$message.error(response.data.message);
                        }
                        this.changeClientId(this.clientId);
                    })
                    .catch(error => {
                        this.$message.error(error.response.data.message);
                    })
                    .then(() => {
                        row.loading = false;
                    })
            },
            clickValidate(row) {
                row.loading = true
                this.$http.post(`/${this.resource}/validate`, {
                    'client_id': this.clientId,
                    'external_id': row.external_id
                })
                    .then(response => {
                        if (response.data.success) {
                            this.$message.success(response.data.message)
                        } else {
                            this.$message.error(response.data.message)
                        }
                        this.changeClientId(this.clientId);
                    })
                    .catch(error => {
                        this.$message.error(error.response.data.message)
                    })
                    .then(() => {
                        row.loading = false;
                    })
            },
        }
    }
</script>
