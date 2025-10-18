@extends('layouts.default')

@section('title')
    Profil
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Home</a></li>
    <li class="breadcrumb-item active">Profil</li>
@endsection

@section('content')
    <!-- Default box -->
    <div class="card" x-data="form" id="formComponent">
        <div class="card-header">
            <h3 class="card-title">Profil Pegawai</h3>
        </div>
        <form @submit.prevent="submit">
            <div class="card-body row">

                <div class="form-group col-6">
                    @php($formName = 'nip')
                    @php($formLabel = 'NIP')
                    <label for="{{$formName}}">{{$formLabel}}</label>
                    <input type="text" class="form-control" id="{{$formName}}" placeholder="{{$formLabel}}"
                           x-model.lazy="formData.{{$formName}}"
                           :class="{'is-invalid': validationErrors.{{$formName}}}">
                    <template x-if="validationErrors.{{$formName}}">
                        <div class="invalid-feedback" x-text="validationErrors.{{$formName}}"></div>
                    </template>
                </div>

                <div class="form-group col-6">
                    @php($formName = 'nama')
                    @php($formLabel = 'Nama')
                    <label for="{{$formName}}">{{$formLabel}}</label>
                    <input type="text" class="form-control" id="{{$formName}}" placeholder="{{$formLabel}}"
                           x-model.lazy="formData.{{$formName}}"
                           :class="{'is-invalid': validationErrors.{{$formName}}}">
                    <template x-if="validationErrors.{{$formName}}">
                        <div class="invalid-feedback" x-text="validationErrors.{{$formName}}"></div>
                    </template>
                </div>

                <div class="form-group col-6">
                    @php($formName = 'skpd')
                    @php($formLabel = 'SKPD')
                    <label for="{{$formName}}">{{$formLabel}}</label>
                    <input readonly type="text" class="form-control" id="{{$formName}}" placeholder="{{$formLabel}}"
                           x-model.lazy="formData.{{$formName}}"
                           :class="{'is-invalid': validationErrors.{{$formName}}}">
                    <template x-if="validationErrors.{{$formName}}">
                        <div class="invalid-feedback" x-text="validationErrors.{{$formName}}"></div>
                    </template>
                </div>

                <div class="form-group col-6">
                    @php($formName = 'bidang')
                    @php($formLabel = 'Bidang')
                    <label for="{{$formName}}">{{$formLabel}}</label>
                    <input readonly type="text" class="form-control" id="{{$formName}}" placeholder="{{$formLabel}}"
                           x-model.lazy="formData.{{$formName}}"
                           :class="{'is-invalid': validationErrors.{{$formName}}}">
                    <template x-if="validationErrors.{{$formName}}">
                        <div class="invalid-feedback" x-text="validationErrors.{{$formName}}"></div>
                    </template>
                </div>

                <div class="form-group col-6">
                    @php($formName = 'password')
                    @php($formLabel = 'Password')
                    <label for="{{$formName}}">{{$formLabel}}</label>
                    <input type="password" class="form-control" id="{{$formName}}" placeholder="{{$formLabel}}"
                           x-model.lazy="formData.{{$formName}}"
                           :class="{'is-invalid': validationErrors.{{$formName}}}">
                    <template x-if="validationErrors.{{$formName}}">
                        <div class="invalid-feedback" x-text="validationErrors.{{$formName}}"></div>
                    </template>
                </div>

                <div class="form-group col-6">
                    @php($formName = 'password_confirmation')
                    @php($formLabel = 'Konfirmasi Password')
                    <label for="{{$formName}}">{{$formLabel}}</label>
                    <input type="password" class="form-control" id="{{$formName}}" placeholder="{{$formLabel}}"
                           x-model.lazy="formData.{{$formName}}"
                           :class="{'is-invalid': validationErrors.{{$formName}}}">
                    <template x-if="validationErrors.{{$formName}}">
                        <div class="invalid-feedback" x-text="validationErrors.{{$formName}}"></div>
                    </template>
                </div>

            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
    <!-- /.card -->
@endsection

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('form', () => ({
                formData: {
                    nip: '',
                    nama: '',
                    skpd: '',
                    bidang: '',
                    password: '',
                    password_confirmation: '',
                },
                validationErrors: {},

                async initData() {
                    let res = await axios.post(`/profil`);
                    let data = res.data;

                    data.skpd = data.skpd.skpd;
                    data.bidang = data.bidang.bidang;

                    for (let key in this.formData) {
                        if (data.hasOwnProperty(key)) {
                            this.formData[key] = data[key];
                        }
                    }
                },

                async submit() {
                    try {
                        await axios.put('/profil', this.formData);

                        window.location.href = '/profil';
                    } catch (err) {
                        if (err.response?.status === 422) {
                            this.validationErrors = err.response.data.errors ?? {};
                        } else {
                            toastr.error('Terjadi kesalahan sistem. Silahkan refresh halaman ini. Jika error masih terjadi, silahkan hubungi Tim IT.');
                        }
                    }
                }

            }));
        });

        $(document).ready(function() {
            formComponent = document.getElementById('formComponent');

            formAlpine = Alpine.$data(formComponent);

            formAlpine.initData();
        });
    </script>
@endpush
