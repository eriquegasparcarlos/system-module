<template>
    <div class="login-auth">
        <div class="container">
            <div class="row justify-content-center">
                <div class="login-auth-image">
                    <img :src="$urlImageLogin" />
                </div>
                <div class="login-auth-card">
                    <div class="card-body">
                        <form autocomplete="on" @submit.prevent="submit">
                            <div class="form-body">
                                <div class="row m-b-30">
                                    <div class="col-12">
                                        <h2 class="login-auth-card__title tx-color-01">{{ title }}</h2>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <x-form-group label="Correo electrónico" :error="errors.email">
                                            <el-input v-model="form.email">
                                                <i slot="prefix" class="el-input__icon mdi mdi-mail-ru"></i>
                                            </el-input>
                                        </x-form-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <x-form-group label="Contraseña" :error="errors.password">
                                            <el-input v-model="form.password" show-password>
                                                <i slot="prefix" class="el-input__icon mdi mdi-key"></i>
                                            </el-input>
                                        </x-form-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <el-checkbox v-model="form.remember"> Recordarme</el-checkbox>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <el-button type="primary" native-type="submit" :loading="loading_submit">
                                    <template v-if="loading_submit">
                                        Iniciando...
                                    </template>
                                    <template v-else>
                                        Continuar
                                    </template>
                                </el-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>

    export default {
        data() {
            return {
                loading_submit: false,
                title: 'Iniciar sesión',
                errors: {},
                form: {},
            }
        },
        methods: {
            initForm() {
                this.errors = {};
                this.form = {
                    email: null,
                    password: null,
                    remember: false,
                }
            },
            submit() {
                this.loading_submit = true;
                this.$http.post(`/administrator/login`, this.form)
                    .then(() => {
                           window.location.pathname = '/administrator';
                    })
                    .catch(error => {
                        this.loading_submit = false;
                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors;
                        } else {
                            console.log(error)
                        }
                    });
            },
        }
    }
</script>
