Alpine.data('pegawai_form', () => ({
    formData: {
        skpd: '',
        bidang: '',
        nip: '',
        nama: '',
        password: '',
        password_confirmation: '',
    },
    validationErrors: {},

    async initData(uuid) {
        let res = await axios.get(`/pegawai/${uuid}`);
        let data = res.data;

        data.skpd = data.skpd.uuid;
        data.bidang = data.bidang.uuid;

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

                await axios.post(`/pegawai/${uuid}`, formData);
            } else {
                await axios.post('/pegawai', formData);
            }

            window.location.href = '/pegawai';
        } catch (err) {
            if (err.response?.status === 422) {
                this.validationErrors = err.response.data.errors ?? {};
            } else {
                toastr.error('Terjadi kesalahan sistem. Silahkan refresh halaman ini. Jika error masih terjadi, silahkan hubungi Tim IT.');
            }
        }
    },

    async initSelect2() {
        let initData = await init();

        async function init() {
            console.log({ uuid });
            let bidangElement = $('#bidang');

            $('#skpd').change(async function () {
                await onSkpdChange($(this).val(), bidangElement);
            });
            $('#skpd').change();

            return { bidangElement };
        }

        async function onSkpdChange(skpd, bidangElement) {
            if (skpd) {
                let res = await axios.post(`/helper/getBidangBySkpd/${skpd}`);

                selectWithDatasetAndInit(bidangElement, 'Pilih Bidang', res.data);
            } else {
                emptySelectWithPlaceholderAndInit(bidangElement, 'Pilih SKPD Terlebih Dahulu');
            }
        }
    },
}));
