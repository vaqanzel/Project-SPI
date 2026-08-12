@extends('layout.app')

@section('title', 'MR')

@push('style')
<style>
    .spi-mr-wrap {
        padding-top: 12px !important;
    }

    .spi-mr-wrap .section > *:first-child {
        margin-top: 0;
    }

    .spi-mr-wrap .spi-page-header {
        margin-top: -4px !important;
        margin-bottom: 18px;
    }

    .spi-mr-wrap .section-body {
        padding-top: 0;
    }

    .spi-mr-toolbar {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 14px;
        flex-wrap: wrap;
        padding: 14px 16px;
        margin-bottom: 20px;
        background: #fff;
        border: 1px solid #DBEAFE;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(23, 63, 158, 0.08);
    }

    .spi-mr-toolbar-group {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        align-items: center;
    }

    .spi-mr-toolbar .spi-btn {
        min-height: 38px;
    }

    @media (max-width: 576px) {
        .spi-mr-wrap {
            padding-top: 8px !important;
        }

        .spi-mr-toolbar {
            padding: 12px;
        }
    }
</style>
@endpush

@section('main')
@foreach($elements as $element)
    @foreach($element->ManagementSubElement as $subElement)
        @foreach($subElement->ManagementTopic as $topic)
            @foreach($topic->Uraian as $uraian)
                <div class="modal fade" id="editUraianModal{{ $uraian->id }}" tabindex="-1" aria-labelledby="editUraianModalLabel{{ $uraian->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content" style="background-color: #fff; color: #000;">
                            <div class="modal-header" style="border-bottom: 1px solid #000;">
                                <h5 class="modal-title" id="editUraianModalLabel{{ $uraian->id }}">Edit Uraian</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: #000;"></button>
                            </div>
                            <form action="{{ route('uraian.update', $uraian->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body" style="background-color: #fff; color: #000;">
                                    <div class="form-group mt-3">
                                        <label for="level" style="color: #000;">Level</label>
                                        <input type="number" class="form-control" id="level" name="level" min="1" value="{{ $uraian->level }}" required style="background-color: #fff; color: #000;">
                                    </div> 
                                    <div class="form-group">
                                        <label for="uraian" style="color: #000;">Uraian</label>
                                        <textarea class="form-control" id="uraian" name="uraian" rows="7" required style="background-color: #fff; color: #000;">{{ $uraian->uraian }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer" style="background-color: #fff;">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" >Tutup</button>
                                    <button type="submit" class="btn btn-primary" >Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach
    @endforeach
@endforeach

<div class="modal fade" id="addSubElementModal" tabindex="-1" role="dialog" aria-labelledby="addSubElementModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #fff; color: #000;">
                    <h5 class="modal-title" id="addSubElementModalLabel">Tambah Sub Elemen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('subElemen.store') }}" method="POST">
                    @csrf
                    <div class="modal-body" style="background-color: #fff;">
                        <div class="form-group">
                            <label for="element">Pilih Elemen:</label>
                            <select class="form-control" id="element" name="id_management_element" required>
                                <option value="" disabled selected>Pilih Elemen</option>
                                @foreach($elements as $element)
                                    <option value="{{ $element->id }}">{{ $element->elemen }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="sub_element">Sub Elemen:</label>
                            <textarea class="form-control" id="sub_element" name="sub_elemen" rows="5" required></textarea></div>
                        </div>
                        <div class="modal-footer" style="background-color: #fff;">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" >Tutup</button>
                            <button type="submit" class="btn btn-primary" >Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<div class="modal fade" id="addTopicModal" tabindex="-1" role="dialog" aria-labelledby="addTopicModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #fff; color: #000;">
                <h5 class="modal-title" id="addTopicModalLabel">Tambah Topik</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('topic.store') }}" method="POST">
                @csrf
                <div class="modal-body" style="background-color: #fff;">
                    <div class="form-group">
                        <label for="elementSelect">Pilih Elemen:</label>
                        <select class="form-control" id="elementSelect" name="id_management_element" required>
                            <option value="" disabled selected>Pilih Elemen</option>
                            @foreach($elements as $element)
                                <option value="{{ $element->id }}">{{ $element->elemen }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="subElementSelect">Pilih Sub Elemen:</label>
                        <select class="form-control" id="subElementSelect" name="id_management_sub_element" required>
                            @foreach($subElements as $subElement)
                                <option value="{{ $subElement->id }}" data-element-id="{{ $subElement->id_management_element }}">
                                    {{ $subElement->sub_elemen }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="topic">Topik:</label>
                        <textarea class="form-control" id="topic" name="topik" rows="5" required></textarea>

                    </div>
                </div>
                <div class="modal-footer" style="background-color: #fff;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" >Tutup</button>
                    <button type="submit" class="btn btn-primary" >Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addUraianModal" tabindex="-1" role="dialog" aria-labelledby="addUraianModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #fff; color: #000;">
                <h5 class="modal-title" id="addUraianModalLabel">Tambah Uraian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('uraian.store') }}" method="POST">
                @csrf
                <div class="modal-body" style="background-color: #f8f9fa;">
                    <div class="form-group">
                        <label for="elementUraian">Pilih Elemen:</label>
                        <select class="form-control" id="elementUraian" name="id_management_element" required>
                            <option value="" disabled selected>Pilih Elemen</option>
                            @foreach($elements as $element)
                                <option value="{{ $element->id }}">{{ $element->elemen }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="subElementUraian">Pilih Sub Elemen:</label>
                        <select class="form-control" id="subElementUraian" name="id_management_sub_element" required>
                            @foreach($subElements as $subElement)
                                <option value="{{ $subElement->id }}" data-element-id="{{ $subElement->id_management_element }}">
                                    {{ $subElement->sub_elemen }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="topicUraian">Pilih Topik:</label>
                        <select class="form-control" id="topicUraian" name="id_management_topic" required>
                            @foreach($topics as $topic)
                                <option value="{{ $topic->id }}" data-sub-element-id="{{ $topic->id_management_sub_element }}">
                                    {{ $topic->topik }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="level">Level:</label>
                        <input type="number" class="form-control" id="level" name="level" required min="1">
                    </div>
                    <div class="form-group">
                        <label for="uraian">Uraian:</label>
                        <textarea class="form-control" id="uraian" name="uraian" rows="5" required></textarea>

                    </div>
                </div>
                <div class="modal-footer" style="background-color: #fff;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" >Tutup</button>
                    <button type="submit" class="btn btn-primary" >Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addElementModal" tabindex="-1" aria-labelledby="addElementModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="background-color: #fff; color: #000;">
            <div class="modal-header" style="border-bottom: 1px solid #000;">
                <h5 class="modal-title" id="addElementModalLabel">Tambah Elemen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: #000;">&times;</span>
                </button>
            </div>
            <form action="{{ route('MR.store') }}" method="POST">
                @csrf
                <div class="modal-body" style="background-color: #fff; color: #000;">
                    <div class="form-group">
                        <label for="elemen" style="color: #000;">Elemen</label>
                        <textarea name="elemen" class="form-control" rows="5" required style="background-color: #fff; color: #000;"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #fff;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" >Tutup</button>
                    <button type="submit" class="btn btn-primary" >Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($elements as $element)
<div class="modal fade" id="editElementModal{{ $element->id }}" tabindex="-1" aria-labelledby="editElementModalLabel{{ $element->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #fff; color: #000;">
            <div class="modal-header" style="border-bottom: 1px solid #000;">
                <h5 class="modal-title" id="editElementModalLabel{{ $element->id }}">Edit Elemen</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('MR.update', $element->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body" style="background-color: #fff; color: #fff;">
                    <div class="form-group">
                        <label for="elemen" style="color: #000;">Elemen</label>
                        <textarea class="form-control" id="elemen" name="elemen" rows="5" required style="background-color: #fff; color: #000;">{{ $element->elemen }}</textarea>
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #fff;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" >Tutup</button>
                    <button type="submit" class="btn btn-primary" >Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@foreach($elements as $element)
    @foreach($element->ManagementSubElement as $subElement)
        <div class="modal fade" id="editSubElementModal{{ $subElement->id }}" tabindex="-1" aria-labelledby="editSubElementModalLabel{{ $subElement->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="background-color: #fff; color: #000;">
                    <div class="modal-header" style="border-bottom: 1px solid #000;">
                        <h5 class="modal-title" id="editSubElementModalLabel{{ $subElement->id }}">Edit Sub Elemen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: #fff;"></button>
                    </div>
                    <form action="{{ route('subElemen.update', $subElement->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body" style="background-color: #fff; color: #fff;">
                            <div class="form-group">
                                <label for="sub_elemen" style="color: #000;">Sub Elemen</label>
                                <textarea class="form-control" id="sub_elemen" name="sub_elemen" rows="5" required style="background-color: #fff; color: #000;">{{ $subElement->sub_elemen }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer" style="background-color: #fff;">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" >Tutup</button>
                            <button type="submit" class="btn btn-primary" >Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endforeach
@foreach($elements as $index => $element)
@foreach($element->ManagementSubElement as $subIndex => $subElement)
@foreach($subElement->ManagementTopic as $topicIndex => $topic)
<div class="modal fade" id="editTopicModal{{ $topic->id }}" tabindex="-1" role="dialog" aria-labelledby="editTopicModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="background-color: #fff; color: #000;">
            <div class="modal-header" style="border-bottom: 1px solid #000;">
                <h5 class="modal-title" id="editTopicModalLabel">Edit Topic</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: #000;">&times;</span>
                </button>
            </div>
            <form action="{{ route('topic.update', $topic->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body" style="background-color: #fff; color: #fff;">
                    <div class="form-group">
                        <label for="topik" style="color: #000;">Topic</label>
                        <textarea class="form-control" id="topik" name="topik" rows="7" style="background-color: #fff; color: #000;">{{ $topic->topik }}</textarea>
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #fff;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" >Tutup</button>
                    <button type="submit" class="btn btn-primary" >Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endforeach 
@endforeach

<div class="main-content spi-mr-wrap" style="position:fixed; top:70px; left:280px; right:0; bottom:0; margin:0 !important; padding:24px 30px 20px !important; overflow-y:auto; overflow-x:hidden; z-index:1;">
    <section class="section">

        {{-- ─── Page Header ─── --}}
        <div class="spi-page-header">
            <div class="spi-page-header-left">
                <div class="spi-page-breadcrumb">
                    <i class="fas fa-home" style="font-size:0.7rem;"></i>
                    <span class="spi-page-breadcrumb-sep"><i class="fas fa-chevron-right"></i></span>
                    <a href="{{ url('/dashboard') }}">Dashboard</a>
                    <span class="spi-page-breadcrumb-sep"><i class="fas fa-chevron-right"></i></span>
                    <span class="spi-page-breadcrumb-current">Maturity Rating (MR)</span>
                </div>
                <h1 class="spi-page-title">Maturity Rating</h1>
                <p class="spi-page-subtitle">Kelola elemen, sub elemen, topik, dan uraian penilaian kapabilitas pengawasan internal.</p>
            </div>
            <div class="spi-page-header-actions">
                <a href="{{ url()->previous() }}" class="spi-btn spi-btn-ghost">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </div>

        <div class="section-body">
            @if(session('success'))
                <div class="spi-alert spi-alert-success" style="margin-bottom:20px;">
                    <i class="fas fa-check-circle spi-alert-icon"></i>
                    <div class="spi-alert-body">{{ session('success') }}</div>
                    <button class="spi-alert-close" onclick="this.closest('.spi-alert').remove();">&times;</button>
                </div>
            @elseif($errors->any())
                <div class="spi-alert spi-alert-danger" style="margin-bottom:20px;">
                    <i class="fas fa-times-circle spi-alert-icon"></i>
                    <div class="spi-alert-body">
                        <ul style="margin:0; padding-left:16px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            <div class="spi-mr-toolbar">
                @if(auth()->user()->id_level == 1 || auth()->user()->id_level == 2 || auth()->user()->id_level == 6)
                    <div class="spi-mr-toolbar-group" style="margin-bottom:10px;">
                        <a href="{{ route('entitas.index') }}" class="spi-btn spi-btn-outline spi-btn-sm">Entitas</a>
                        <a href="{{ route('bobot.index') }}" class="spi-btn spi-btn-outline spi-btn-sm">Bobot</a>
                        <a href="{{ route('verif.index') }}" class="spi-btn spi-btn-outline spi-btn-sm">Validasi</a>
                        <a href="{{ route('kesimpulan.index') }}" class="spi-btn spi-btn-outline spi-btn-sm">Kesimpulan</a>
                    </div>
                @endif
                @if(auth()->user()->id_level == 1 || auth()->user()->id_level == 2)
                    <div class="spi-mr-toolbar-group">
                        <button type="button" class="spi-btn spi-btn-primary spi-btn-sm" data-toggle="modal" data-target="#addElementModal">
                            <i class="fas fa-plus"></i> Elemen
                        </button>
                        <button type="button" class="spi-btn spi-btn-success spi-btn-sm" data-toggle="modal" data-target="#addSubElementModal">
                            <i class="fas fa-plus"></i> Sub Elemen
                        </button>
                        <button type="button" class="spi-btn spi-btn-success spi-btn-sm" data-toggle="modal" data-target="#addTopicModal">
                            <i class="fas fa-plus"></i> Topik
                        </button>
                        <button type="button" class="spi-btn spi-btn-success spi-btn-sm" data-toggle="modal" data-target="#addUraianModal">
                            <i class="fas fa-plus"></i> Uraian
                        </button>
                    </div>
                @endif
            </div>
        
        @if($elements->isEmpty())
            <p>Tidak ada elemen yang ditemukan.</p>
        @else
            @foreach($elements as $index => $element)
            <div class="accordion mb-3" id="accordionExample{{ $index }}">
                <div style="border-radius:12px; overflow:hidden; border:1px solid #DBEAFE; box-shadow:0 2px 8px rgba(23,63,158,0.08);">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background:linear-gradient(135deg,#173F9E,#1E4FBF); color:#fff; padding:14px 18px; cursor:pointer;" id="heading{{ $index }}">
                        <h5 class="mb-0" style="display:flex; align-items:center; gap:10px;">
                            <div style="width:26px; height:26px; background:rgba(255,255,255,0.18); border-radius:7px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <i class="fas fa-layer-group" style="font-size:0.75rem;"></i>
                            </div>
                            <button class="btn btn-link" style="color:#fff; font-weight:700; font-size:0.9rem; text-decoration:none; padding:0;" type="button" data-toggle="collapse" data-target="#collapse{{ $index }}" aria-expanded="true" aria-controls="collapse{{ $index }}">
                                {{ $element->elemen }}
                            </button>
                        </h5>
                        @if(auth()->user()->id_level == 1 || auth()->user()->id_level == 2)
                        <div style="display:flex; gap:6px; align-items:center;">
                            <button type="button" class="spi-btn spi-btn-icon-sm" style="background:rgba(255,255,255,0.2); color:#fff; border-color:rgba(255,255,255,0.3);" data-toggle="modal" data-target="#editElementModal{{ $element->id }}" title="Edit Elemen">
                                <i class="fa fa-edit"></i>
                            </button>
                            <form action="{{ route('MR.destroy', ['id' => $element->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus elemen ini?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="spi-btn spi-btn-icon-sm" style="background:rgba(239,68,68,0.3); color:#fff; border-color:rgba(239,68,68,0.4);" title="Hapus Elemen">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                    <div id="collapse{{ $index }}" class="collapse" aria-labelledby="heading{{ $index }}" data-parent="#accordionExample{{ $index }}">
                        <div class="card-body">
                            @if($element->ManagementSubElement->isEmpty())
                                <p>Tidak ada sub elemen yang ditemukan.</p>
                            @else
                                @foreach($element->ManagementSubElement as $subIndex => $subElement)
                                <div class="accordion" id="subAccordion{{ $index }}{{ $subIndex }}">
                                    <div style="border-radius:10px; overflow:hidden; border:1px solid #BFDBFE; margin-bottom:8px;">
                                        <div class="card-header d-flex justify-content-between align-items-center" style="background:#1E5BA8; color:#fff; padding:11px 16px; cursor:pointer;" id="subHeading{{ $index }}{{ $subIndex }}">
                                            <h6 class="mb-0" style="display:flex; align-items:center; gap:8px;">
                                                <div style="width:22px; height:22px; background:rgba(255,255,255,0.18); border-radius:6px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                                    <i class="fas fa-folder" style="font-size:0.65rem;"></i>
                                                </div>
                                                <button class="btn btn-link" style="color:#fff; font-weight:600; font-size:0.85rem; text-decoration:none; padding:0;" type="button" data-toggle="collapse" data-target="#subCollapse{{ $index }}{{ $subIndex }}" aria-expanded="true" aria-controls="subCollapse{{ $index }}{{ $subIndex }}">
                                                    {{ $subElement->sub_elemen }}
                                                </button>
                                            </h6>
                                            @if(auth()->user()->id_level == 1 || auth()->user()->id_level == 2)
                                            <div style="display:flex; gap:6px;">
                                                <button type="button" class="spi-btn spi-btn-icon-sm" style="background:rgba(255,255,255,0.2); color:#fff; border-color:rgba(255,255,255,0.3);" data-toggle="modal" data-target="#editSubElementModal{{ $subElement->id }}" title="Edit Sub Elemen">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <form action="{{ route('subElemen.destroy', $subElement->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus sub elemen ini?');" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="spi-btn spi-btn-icon-sm" style="background:rgba(239,68,68,0.3); color:#fff; border-color:rgba(239,68,68,0.4);" title="Hapus Sub Elemen">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            @endif
                                        </div>
                                        <div id="subCollapse{{ $index }}{{ $subIndex }}" class="collapse" aria-labelledby="subHeading{{ $index }}{{ $subIndex }}" data-parent="#subAccordion{{ $index }}{{ $subIndex }}">
                                            <div class="card-body">
                                                @if($subElement->ManagementTopic->isEmpty())
                                                    <p>Tidak ada topik yang ditemukan.</p>
                                                @else
                                                    @foreach($subElement->ManagementTopic as $topicIndex => $topic)
                                                    <div class="accordion" id="topicAccordion{{ $index }}{{ $subIndex }}{{ $topicIndex }}">
                                                        <div style="border-radius:9px; overflow:hidden; border:1px solid #E0E7FF; margin-bottom:6px;">
                                                            <div class="card-header d-flex justify-content-between align-items-center" style="background:#EAF0FF; color:#1E293B; padding:10px 14px; cursor:pointer;" id="topicHeading{{ $index }}{{ $subIndex }}{{ $topicIndex }}">
                                                                <h6 class="mb-0" style="display:flex; align-items:center; gap:8px;">
                                                                    <div style="width:20px; height:20px; background:#DBEAFE; border-radius:5px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                                                        <i class="fas fa-file-alt" style="font-size:0.6rem; color:#173F9E;"></i>
                                                                    </div>
                                                                    <button class="btn btn-link" style="color:#1E3A8A; font-weight:600; font-size:0.83rem; text-decoration:none; padding:0;" type="button" data-toggle="collapse" data-target="#topicCollapse{{ $index }}{{ $subIndex }}{{ $topicIndex }}" aria-expanded="true" aria-controls="topicCollapse{{ $index }}{{ $subIndex }}{{ $topicIndex }}">
                                                                        {{ $topic->topik }}
                                                                    </button>
                                                                </h6>
                                                                @if(auth()->user()->id_level == 1 || auth()->user()->id_level == 2)
                                                                <div style="display:flex; gap:6px;">
                                                                    <button type="button" class="spi-btn spi-btn-icon-sm" data-toggle="modal" data-target="#editTopicModal{{ $topic->id }}" title="Edit Topik">
                                                                        <i class="fa fa-edit"></i>
                                                                    </button>
                                                                    <form action="{{ route('topic.destroy', $topic->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus topik ini?');" style="display:inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="spi-btn spi-btn-icon-sm spi-btn-danger" title="Hapus Topik">
                                                                            <i class="fa fa-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                                @endif
                                                            </div>
                                                            <div id="topicCollapse{{ $index }}{{ $subIndex }}{{ $topicIndex }}" class="collapse" aria-labelledby="topicHeading{{ $index }}{{ $subIndex }}{{ $topicIndex }}" data-parent="#topicAccordion{{ $index }}{{ $subIndex }}{{ $topicIndex }}">
                                                                <div class="card-body">
                                                                    @foreach($topic->Uraian->groupBy('level') as $level => $uraians)
                                                                    <div class="accordion" id="levelAccordion{{ $index }}{{ $subIndex }}{{ $topicIndex }}{{ $level }}">
                                                                        <div style="border-radius:8px; overflow:hidden; border:1px solid #F1F5F9; margin-bottom:6px;">
                                                                            <div class="card-header d-flex justify-content-between align-items-center" style="background:#F8FAFC; color:#1E293B; padding:9px 14px; border-bottom:1px solid #E2E8F0; cursor:pointer;" id="levelHeading{{ $index }}{{ $subIndex }}{{ $topicIndex }}{{ $level }}">
                                                                                <h6 class="mb-0" style="display:flex; align-items:center; gap:8px;">
                                                                                    <span style="font-size:0.72rem; font-weight:700; color:#fff; background:#173F9E; padding:2px 8px; border-radius:20px;">Lvl {{ $level }}</span>
                                                                                    <button class="btn btn-link" style="color:#1E293B; font-weight:600; font-size:0.82rem; text-decoration:none; padding:0;" type="button" data-toggle="collapse" data-target="#levelCollapse{{ $index }}{{ $subIndex }}{{ $topicIndex }}{{ $level }}" aria-expanded="true" aria-controls="levelCollapse{{ $index }}{{ $subIndex }}{{ $topicIndex }}{{ $level }}">
                                                                                        Uraian Level {{ $level }}
                                                                                    </button>
                                                                                </h6>
                                                                            </div>
                                                                            <div id="levelCollapse{{ $index }}{{ $subIndex }}{{ $topicIndex }}{{ $level }}" class="collapse" aria-labelledby="levelHeading{{ $index }}{{ $subIndex }}{{ $topicIndex }}{{ $level }}" data-parent="#levelAccordion{{ $index }}{{ $subIndex }}{{ $topicIndex }}{{ $level }}">
                                                                                <div class="card-body">
                                                                                    <div class="table-responsive">
                                                                                        <form action="{{ route('MR.update', ['id' => $level]) }}" method="POST" enctype="multipart/form-data">
                                                                                            @csrf
                                                                                            @method('PUT')
                                                                                            <table class="table table-bordered">
                                                                                                <thead class="thead-light">
                                                                                                    <tr>
                                                                                                        <th>No.</th>
                                                                                                        <th style="width: 80%;">Uraian</th> 
                                                                                                        @if(auth()->user()->id_level == 1 || auth()->user()->id_level == 2)
                                                                                                        <th>Aksi</th>
                                                                                                        @endif
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                    @foreach($topic->Uraian as $uraianIndex => $uraian)
                                                                                                        <tr>
                                                                                                            <td>{{ $uraianIndex + 1 }}</td>
                                                                                                            <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;">
                                                                                                                {{ $uraian->uraian }}
                                                                                                            </td>
                                                                                                            @if(auth()->user()->id_level == 1 || auth()->user()->id_level == 2)
                                                                                                            <td style="white-space:nowrap;">
                                                                                                                <div style="display:flex; gap:4px;">
                                                                                                                    <button type="button" class="spi-btn spi-btn-icon-sm" data-toggle="modal" data-target="#editUraianModal{{ $uraian->id }}" title="Edit Uraian">
                                                                                                                        <i class="fa fa-edit"></i>
                                                                                                                    </button>
                                                                                                                    <form action="{{ route('uraian.destroy', $uraian->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus uraian ini?');" style="display:inline;">
                                                                                                                        @csrf
                                                                                                                        @method('DELETE')
                                                                                                                        <button type="submit" class="spi-btn spi-btn-icon-sm spi-btn-danger" title="Hapus Uraian">
                                                                                                                            <i class="fa fa-trash"></i>
                                                                                                                        </button>
                                                                                                                    </form>
                                                                                                                </div>
                                                                                                            </td>
                                                                                                            @endif
                                                                                                        </tr>
                                                                                                    @endforeach
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
        </div>
    </section>
</div>
<script>
    setTimeout(function() {
        let alertElement = document.querySelector('.alert');
        if (alertElement) {
            alertElement.style.transition = 'opacity 1s';
            alertElement.style.opacity = '0';
            setTimeout(() => alertElement.remove(), 1000);
        }
    }, 2000);
    document.addEventListener('DOMContentLoaded', function () {
        const openedAccordions = JSON.parse(localStorage.getItem('openedAccordions')) || [];
        openedAccordions.forEach(id => {
            const accordion = document.getElementById(id);
            if (accordion) {
                new bootstrap.Collapse(accordion, {
                    toggle: false
                }).show();
            }
        });

        document.querySelectorAll('[data-toggle="collapse"]').forEach(button => {
            button.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target').substring(1); 
                const accordion = document.getElementById(targetId);
                const openedAccordions = JSON.parse(localStorage.getItem('openedAccordions')) || [];

                if (accordion.classList.contains('show')) {
                    const index = openedAccordions.indexOf(targetId);
                    if (index > -1) {
                        openedAccordions.splice(index, 1);
                    }
                } else {
                    if (!openedAccordions.includes(targetId)) {
                        openedAccordions.push(targetId);
                    }
                }

                localStorage.setItem('openedAccordions', JSON.stringify(openedAccordions));
            });
        });
    });

document.addEventListener('DOMContentLoaded', function () {
    const elementSelect = document.getElementById('elementSelect');
    const subElementSelect = document.getElementById('subElementSelect');

    elementSelect.addEventListener('change', function () {
        const selectedElementId = this.value;

        Array.from(subElementSelect.options).forEach(option => {
            option.style.display = option.getAttribute('data-element-id') === selectedElementId ? 'block' : 'none';
        });

        const firstVisibleOption = Array.from(subElementSelect.options).find(option => option.style.display === 'block');
        if (firstVisibleOption) {
            subElementSelect.value = firstVisibleOption.value;
        } else {
            subElementSelect.value = '';
        }
    });

    elementSelect.dispatchEvent(new Event('change'));
});

document.addEventListener('DOMContentLoaded', function () {
    const elementUraianSelect = document.getElementById('elementUraian');
    const subElementUraianSelect = document.getElementById('subElementUraian');
    const topicUraianSelect = document.getElementById('topicUraian');

    elementUraianSelect.addEventListener('change', function () {
        const selectedElementId = this.value;

        Array.from(subElementUraianSelect.options).forEach(option => {
            option.style.display = option.getAttribute('data-element-id') === selectedElementId ? 'block' : 'none';
        });

        subElementUraianSelect.dispatchEvent(new Event('change'));
    });

    subElementUraianSelect.addEventListener('change', function () {
        const selectedSubElementId = this.value;

        Array.from(topicUraianSelect.options).forEach(option => {
            option.style.display = option.getAttribute('data-sub-element-id') === selectedSubElementId ? 'block' : 'none';
        });

        const firstVisibleOption = Array.from(topicUraianSelect.options).find(option => option.style.display === 'block');
        topicUraianSelect.value = firstVisibleOption ? firstVisibleOption.value : '';
    });

    elementUraianSelect.dispatchEvent(new Event('change'));
});
</script>
@endsection
    
