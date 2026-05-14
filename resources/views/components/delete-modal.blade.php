<!-- Alert Delete Modal -->
<div id="deleteModal"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 animate-fadeIn">
        <!-- Icon -->
        <div class="flex justify-center mb-4">
            <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center">
                <i class="fas fa-trash text-red-600 text-2xl"></i>
            </div>
        </div>
        <!-- Text -->
        <div class="text-center">
            <h2 class="text-xl font-semibold text-gray-800">
                Hapus Data?
            </h2>
            <p class="text-gray-500 mt-2">
                Data yang dihapus tidak dapat dikembalikan lagi.
            </p>
        </div>
        <!-- Button -->
        <div class="flex justify-center gap-3 mt-6">
            <button type="button"
                    onclick="closeDeleteModal()"
                    class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
                Batal
            </button>
            <form action="" method="POST">
                @csrf
                @method('DELETE')

                <button type="submit"
                        class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>
<script>
    function openDeleteModal(actionUrl) {
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        modal.querySelector('form').action = actionUrl;
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }
</script>