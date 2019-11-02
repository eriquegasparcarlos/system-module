<template>
    <el-dialog :title="titleDialog" :visible="showDialog" :close-on-click-modal="false"  @open="handleOpen" @close="clickClose" class="dialog-small">
        <form autocomplete="off" @submit.prevent="submit" v-loading="loading">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-8">
                        <x-form-group label="Número" :error="errors.number">
                            <x-input-service :identity_document_type_id="form.identity_document_type_id" v-model="form.number" @search="searchNumber"></x-input-service>
                            <!--<el-input v-model="form.number"-->
                                      <!--:maxlength="11"-->
                                      <!--show-word-limit>-->
                                <!--&lt;!&ndash;<el-button type="primary" slot="append" :loading="loading_search" icon="el-icon-search" @click.prevent="searchSunat">&ndash;&gt;-->
                                    <!--&lt;!&ndash;SUNAT&ndash;&gt;-->
                                <!--&lt;!&ndash;</el-button>&ndash;&gt;-->
                            <!--</el-input>-->
                        </x-form-group>
                    </div>
                    <div class="col-md-12">
                        <x-form-group label="Nombre de la Empresa" :error="errors.name">
                            <el-input v-model="form.name"></el-input>
                        </x-form-group>
                    </div>
                    <div class="col-md-12">
                        <!--<x-form-group label="Número" :error="errors.number">-->
                        <!--<el-input v-model="form.number" :maxlength="maxLength">-->
                        <!--<el-button type="primary" slot="append" :loading="loading_search" icon="el-icon-search" @click.prevent="searchCustomer">-->
                        <!--SUNAT-->
                        <!--</el-button>-->
                        <!--</el-input>-->
                        <!--</x-form-group>-->

                        <div class="form-group" :class="{'has-danger': (errors.subdomain || errors.uuid)}">
                            <label class="control-label">Nombre de Subdominio</label>
                            <el-input v-model="form.subdomain">
                                <template slot="append">{{ url_base }}</template>
                            </el-input>
                            <small class="form-control-feedback" v-if="errors.subdomain" v-text="errors.subdomain[0]"></small>
                            <small class="form-control-feedback" v-if="errors.uuid" v-text="errors.uuid[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <x-form-group label="Actividad" :error="errors.activity_id">
                            <el-select v-model="form.activity_id">
                                <el-option key="01" value="01" label="General"></el-option>
                                <el-option key="02" value="02" label="Hospedaje"></el-option>
                            </el-select>
                        </x-form-group>
                    </div>
                    <div class="col-md-12">
                        <x-form-group>
                            <el-checkbox v-model="form.with_data">Generar data inicial</el-checkbox>
                        </x-form-group>
                    </div>
                    <template v-if="form.with_data">
                        <div class="col-md-8">
                            <x-form-group label="Correo de Acceso" :error="errors.email">
                                <el-input v-model="form.email"></el-input>
                            </x-form-group>
                        </div>
                        <div class="col-md-4">
                            <x-form-group label="Contraseña" :error="errors.password">
                                <el-input type="password" v-model="form.password"></el-input>
                            </x-form-group>
                        </div>
                    </template>
                </div>
            </div>
            <div class="form-actions text-right pt-2">
                <el-button @click.prevent="clickClose()">Cancelar</el-button>
                <el-button type="primary" native-type="submit" :loading="loading_submit">
                    <template v-if="loading_submit">
                        Creando cliente...
                    </template>
                    <template v-else>
                        Guardar
                    </template>
                </el-button>
            </div>
        </form>
    </el-dialog>
</template>


<script>

    // import {serviceNumber} from '../../../mixins/functions'

    export default {
        // mixins: [serviceNumber],
        props: ['showDialog', 'recordId'],
        data() {
            return {
                loading: false,
                loading_submit: false,
                titleDialog: null,
                resource: 'administrator/clients',
                error: {},
                form: {},
                url_base: null
            }
        },
        created() {
            this.initForm()
            this.$http.get(`/${this.resource}/tables`)
                .then(response => {
                    this.url_base = response.data.url_base
                })
        },
        methods: {
            initForm() {
                this.errors = {};
                this.form = {
                    id: null,
                    name: null,
                    email: null,
                    identity_document_type_id: '6',
                    number: '',
                    password: null,
                    with_data: true,
                    activity_id: '01'
                }
            },
            async handleOpen() {
                this.loading = true
                this.initForm()
                this.titleDialog = (this.recordId)? 'Editar Cliente':'Nuevo Cliente';
                if (this.recordId) {
                    await this.$http.get(`/${this.resource}/record/${this.recordId}`)
                }
                this.loading = false
            },
            submit() {
                this.loading = true
                this.loading_submit = true
                this.$http.post(`/${this.resource}`, this.form)
                    .then(response => {
                        // console.log(response)
                        if (response.data.success) {
                            this.$message.success(response.data.message)
                            this.$eventHub.$emit('reloadData')
                            this.clickClose()
                        } else {
                            this.$message.error(response.data.message)
                        }
                    })
                    .catch(error => {
                        // console.log(error)
                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors
                        } else {
                            console.log(error.response)
                        }
                    })
                    .then(() => {
                        this.loading_submit = false;
                        this.loading = false;
                    })
            },
            clickClose() {
                this.$emit('update:showDialog', false)
            },
            searchNumber(data) {
                this.form.name = data.razon_social;
                // this.form.trade_name = data.nombre_comercial;
                // this.form.addresses[0].location_id = data.ubigeo;
                // this.form.addresses[0].address = data.direccion;
                // this.form.addresses[0].telephone = data.telefono;
            },
        }
    }
</script>
