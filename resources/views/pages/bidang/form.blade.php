@extends('layouts.default')

@section('title')
    Bidang
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Home</a></li>
    <li class="breadcrumb-item active">Bidang</li>
@endsection

@section('content')
    <!-- Default box -->
    <div class="card" x-data="form" id="formComponent">
        <div class="card-header">
            <h3 class="card-title">{{ isset($bidang) ? 'Ubah' : 'Tambah' }} Data Bidang</h3>
        </div>
        <form @submit.prevent="submit">
            <div class="card-body row">

                <div class="form-group col-6">
                    @php($formName = 'skpd')
                    @php($formLabel = 'SKPD')
                    <label for="{{$formName}}">{{$formLabel}}</label>
                    <select type="text" class="form-control select2" id="{{$formName}}"
                            :class="{'is-invalid': validationErrors.{{$formName}}}">
                        <option value="">{{$formLabel}}</option>
                        @foreach($skpds as $skpd)
                            <option value="{{$skpd->uuid}}">{{$skpd->skpd}}</option>
                        @endforeach
                    </select>
                    <template x-if="validationErrors.{{$formName}}">
                        <div class="invalid-feedback" x-text="validationErrors.{{$formName}}"></div>
                    </template>
                    @push('scripts')
                        <script>
                            $(document).ready(function() {
                                $('#{{$formName}}').change(function() {
                                    formAlpine.formData.{{$formName}} = $(this).val();
                                });
                            });
                        </script>
                    @endpush
                </div>

                <div class="form-group col-6">
                    @php($formName = 'bidang')
                    @php($formLabel = 'Bidang')
                    <label for="{{$formName}}">{{$formLabel}}</label>
                    <input type="text" class="form-control" id="{{$formName}}" placeholder="{{$formLabel}}"
                           x-model.lazy="formData.{{$formName}}"
                           :class="{'is-invalid': validationErrors.{{$formName}}}">
                    <template x-if="validationErrors.{{$formName}}">
                        <div class="invalid-feedback" x-text="validationErrors.{{$formName}}"></div>
                    </template>
                </div>

            </div>

            <div class="card-footer">
                <a href="/bidang">
                    <button type="button" class="btn btn-info">Kembali</button>
                </a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
    <!-- /.card -->
@endsection

@push('scripts')
    <script>
        uuid = @json($bidang?->uuid ?? null);

        document.addEventListener('alpine:init', () => {
            Alpine.data('form', () => ({
                formData: {
                    skpd: '',
                    bidang: '',
                },
                validationErrors: {},

                async initData(uuid) {
                    let res = await axios.get(`/bidang/${uuid}`);
                    let data = res.data;

                    data.skpd = data.skpd.uuid

                    for (let key in this.formData) {
                        if (data.hasOwnProperty(key)) {
                            this.formData[key] = data[key];
                        }
                    }

                    $('#skpd').val(data.skpd).change();
                },

                async submit() {
                    let formData = new FormData();

                    for (let key in this.formData) {
                        formData.append(key, this.formData[key]);
                    }

                    try {
                        if (uuid) {
                            formData.append('_method', 'PUT');

                            await axios.post(`/bidang/${uuid}`, formData);
                        } else {
                            await axios.post('/bidang', formData);
                        }

                        window.location.href = '/bidang';
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

            uuid && formAlpine.initData(uuid);
        });
    </script>
@endpush
