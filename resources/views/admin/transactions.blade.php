                    </tbody>
                    </table>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination">
                        <div class="text-sm text-base-content/70">
                            Menampilkan {{ $transactions->firstItem() }}-{{ $transactions->lastItem() }} dari {{ $transactions->total() }} transaksi
                        </div>
                        <div class="pagination-buttons">
                            @if ($transactions->onFirstPage())
                            <button class="btn btn-sm btn-outline pagination-button" disabled>
                                <i class='bx bx-chevron-left'></i>
                                <span>Sebelumnya</span>
                            </button>
                            @else
                            <a href="{{ $transactions->previousPageUrl() }}" class="btn btn-sm btn-outline pagination-button">
                                <i class='bx bx-chevron-left'></i>
                                <span>Sebelumnya</span>
                            </a>
                            @endif

                            @if ($transactions->hasMorePages())
                            <a href="{{ $transactions->nextPageUrl() }}" class="btn btn-sm btn-outline pagination-button">
                                <span>Selanjutnya</span>
                                <i class='bx bx-chevron-right'></i>
                            </a>
                            @else
                            <button class="btn btn-sm btn-outline pagination-button" disabled>
                                <span>Selanjutnya</span>
                                <i class='bx bx-chevron-right'></i>
                            </button>
                            @endif
                        </div>
                    </div>
                    </div>
                    </div>