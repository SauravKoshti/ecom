{{-- _form.blade.php --}}
<div class="row g-4" style="max-width:760px">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header">Property Info</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-sm-7">
                        <label class="form-label">Name <span style="color:var(--danger)">*</span></label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $property->name ?? '') }}">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-sm-5">
                        <label class="form-label">Type <span style="color:var(--danger)">*</span></label>
                        <select name="type" id="typeSelect"
                                class="form-select @error('type') is-invalid @enderror">
                            @foreach(['select' => 'Select', 'color' => 'Color', 'text' => 'Text'] as $val => $label)
                                <option value="{{ $val }}"
                                    {{ old('type', $property->type ?? 'select') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Options
                <button type="button" class="btn btn-sm btn-outline-primary" id="addOption">
                    <i class="bi bi-plus-lg"></i> Add Option
                </button>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0" id="optionsTable">
                    <thead>
                        <tr>
                            <th>Value <span style="color:var(--danger)">*</span></th>
                            <th id="colorHeader" style="width:120px;display:none">Color</th>
                            <th style="width:48px"></th>
                        </tr>
                    </thead>
                    <tbody id="optionsBody">
                        @php $options = old('options', isset($property) ? $property->options->toArray() : [['value'=>'','color_hex'=>'']]) @endphp
                        @foreach($options as $i => $opt)
                        <tr>
                            @if(!empty($opt['id']))
                                <input type="hidden" name="options[{{ $i }}][id]" value="{{ $opt['id'] }}">
                            @endif
                            <td>
                                <input type="text" name="options[{{ $i }}][value]"
                                       class="form-control form-control-sm @error('options.'.$i.'.value') is-invalid @enderror"
                                       value="{{ $opt['value'] ?? '' }}" placeholder="Option value">
                                @error('options.'.$i.'.value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </td>
                            <td class="color-col" style="display:none">
                                <input type="color" name="options[{{ $i }}][color_hex]"
                                       class="form-control form-control-sm form-control-color"
                                       value="{{ !empty($opt['color_hex']) ? $opt['color_hex'] : '#6366f1' }}">
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-danger remove-option">
                                    <i class="bi bi-x"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
