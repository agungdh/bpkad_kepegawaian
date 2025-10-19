Alpine.data('form', () => ({
    formData: {
        username: '',
        password: '',
    },
    validationErrors: {},
    isSubmitting: false,

    async submit() {
        try {
            this.isSubmitting = true;

            await axios.post('/login', this.formData);

            window.location.href = '/dashboard';
        } catch (err) {
            if (err.response?.status === 422) {
                toastr.error('Username atau password salah');
            } else {
                toastr.error('Terjadi kesalahan saat mengirim data');
            }
        } finally {
            this.isSubmitting = false;
        }
    },
}));
