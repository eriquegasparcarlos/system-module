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
                        <el-button type="primary" @click.prevent="clickCreate()">Nuevo</el-button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <x-data-table :resource="resource">
                                <tr slot="heading">
                                    <th>#</th>
                                    <th class="sort-by" @click.prevent="$eventHub.$emit('clickSort', 'name')">Nombre</th>
                                    <th class="sort-by" @click.prevent="$eventHub.$emit('clickSort', 'number')">Número</th>
                                    <th>Hostname</th>
                                    <th>email</th>
                                    <th>F.Creación</th>
                                    <th class="text-right">Acciones</th>
                                </tr>
                                <tr slot-scope="{index, row}">
                                    <td>{{ index }}</td>
                                    <td>{{ row.number }}</td>
                                    <td>{{ row.name }}</td>
                                    <td>{{ row.hostname }}</td>
                                    <td>{{ row.email }}</td>
                                    <td>{{ row.created_at }}</td>
                                    <td class="text-right">
                                        <el-button size="mini" @click.prevent="$eventHub.$emit('clickDelete', row)" class="btn-default-danger">Eliminar</el-button>
                                    </td>
                                </tr>
                            </x-data-table>
                        </div>
                    </div>
                </div>
                <clients-form :showDialog.sync="showDialog"
                                     :recordId="recordId"></clients-form>
            </div>
        </div>
    </div>
</template>

<script>

    import ClientsForm from './form.vue'
    // import {deletable} from "../../../mixins/deletable"
    // import {changeable} from "../../../mixins/changeable"

    export default {
        // mixins: [changeable],
        components: {ClientsForm},
        data() {
            return {
                showDialog: false,
                resource: 'administrator/clients',
                recordId: null,
                records: [],
                loaded: false,
                year: 2019,
                total_documents: 0,
            }
        },
       created() {
            this.title = 'Clientes'
       },
        methods: {
            clickCreate(recordId = null) {
                this.recordId = recordId
                this.showDialog = true
            },
            // clickPassword(id) {
            //     this.change(`/${this.resource}/password/${id}`)
            // },
        }
    }
</script>
