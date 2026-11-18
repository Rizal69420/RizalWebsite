<x-app-layout>
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Card Header -->
            <div class="px-6 py-4 border-b border-gray-200 flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <span class="text-blue-600 text-xl font-bold">📖</span>
                    <h2 class="text-xl font-bold text-blue-600">Daftar Manager & Pengguna</h2>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-200 font-bold text-sm text-gray-800 bg-gray-50/50">
                            <th class="py-3.5 px-4">Nama</th>
                            <th class="py-3.5 px-4">Email</th>
                            <th class="py-3.5 px-4 text-center">Role / Jabatan</th>
                            <th class="py-3.5 px-4 text-center">Jumlah Pesanan</th>
                            <th class="py-3.5 px-4 text-right">Tanggal Bergabung</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50/70 transition-colors">
                                <td class="py-3.5 px-4 font-semibold text-gray-900">
                                    {{ $user->name }}
                                </td>
                                <td class="py-3.5 px-4 text-gray-600">
                                    {{ $user->email }}
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    @if($user->role === 'admin')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-200">
                                            Manager / Admin
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 border border-gray-200">
                                            Customer
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="text-xs font-medium text-gray-600">
                                        {{ $user->orders_count }} Pesanan
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-right text-xs text-gray-500">
                                    {{ $user->created_at->format('d M Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-gray-500">
                                    Tidak ada data pengguna.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
