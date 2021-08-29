<script>
    $(function () {

        function convertSecondToTime(seconds) {
            /* srtTimestamp */
            let $milliseconds = seconds * 1000;
            $seconds = Math.floor($milliseconds / 1000);
            $minutes = Math.floor($seconds / 60);
            $hours = Math.floor($minutes / 60);
            $milliseconds = $milliseconds % 1000;
            $seconds = $seconds % 60;
            $minutes = $minutes % 60;
            return ($hours < 10 ? '0' : '') + $hours + ':'
                + ($minutes < 10 ? '0' : '') + $minutes + ':'
                + ($seconds < 10 ? '0' : '') + $seconds + ','
                + ($milliseconds < 100 ? '0' : '') + ($milliseconds < 10 ? '0' : '') + $milliseconds;
        }

        $('#upload-act-out-en, #upload-act-out-vi').change(function () {
            let file_sub_en = $('#upload-act-out-en')[0].files;
            let file_sub_vi = $('#upload-act-out-vi')[0].files;

            if (file_sub_en.length > 0 || file_sub_vi.length > 0) {
                let form = new FormData();
                form.append('file_sub_en', file_sub_en != null ? file_sub_en[0] : '');
                form.append('file_sub_vi', file_sub_vi != null ? file_sub_vi[0] : '');

                $.ajax({
                    url: "{{ route('admin.lesson.previewSub') }}",
                    method: 'POST',
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: form,
                    success: function (res) {
                        let htmlData = '<table class="table table-bordered table-hover">';
                        htmlData += '<thead>';
                        htmlData += '<tr>';
                        htmlData += '<th style="width: 30px;">#</th>';
                        htmlData += '<th style="width: 150px;">Chọn nhân vật</th>';
                        htmlData += '<th style="width: 160px;">Time</th>';
                        htmlData += '<th>English</th>';
                        htmlData += '<th>Viet Nam</th>';
                        htmlData += '</tr>';
                        htmlData += '</thead>';
                        htmlData += '<tbody>';

                        res.subtitles.map((element, index) => {
                            /*let userName = index % 2 == 0 ? 'A' : 'B';
                            htmlData += `<tr style="cursor: pointer">
                                                <td>${++index}</td>
                                                <td>
                                                    <input hidden name="actOutId[${index}]" class="form-control form-control-sm" value="-1">
                                                    <input name="actOutUserTag[${index}]" class="form-control form-control-sm tagsinput" data-role="tagsinput" value="${userName}">
                                                </td>
                                                <td>
                                                    <div>
                                                        <span class="item-child-lbl"><i class="fa fa-clock"></i>&nbsp;Time start:&nbsp;</span>
                                                        <span class="item-child-val">${convertSecondToTime(element.startTime)}</span>
                                                        <input name="actOutTimeStart[${index}]" hidden class="form-control form-control-sm" value="${element.startTime}">
                                                    </div>
                                                    <div>
                                                        <span class="item-child-lbl"><i class="fa fa-clock"></i>&nbsp;Time end:&nbsp;</span>
                                                        <span class="item-child-val">${convertSecondToTime(element.endTime)}</span>
                                                        <input name="actOutTimeEnd[${index}]" hidden class="form-control form-control-sm" value="${element.endTime}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <input name="actOutEn[${index}]" class="form-control form-control-sm" value="${element.en}">
                                                </td>
                                                <td>
                                                    <input name="actOutVi[${index}]" class="form-control form-control-sm" value="${element.vi}">
                                                </td>
                                            </tr>`;*/

                            htmlData += `<tr style="cursor: pointer">
                                                <td>${++index}</td>
                                                <td>
                                                    <input hidden name="actOutId[${index}]" class="form-control form-control-sm" value="-1">
                                                    <div class="form-group">
                                                        <div class="form-check form-check">
                                                            <input class="form-check-input" type="radio"
                                                                   name="actOutCharacterId[${index}]"
                                                                   id="character1_${index}" value="1" checked>
                                                            <label class="form-check-label" for="character1_${index}">Nhân vật <span class="badge badge-question">1</span></label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                   name="actOutCharacterId[${index}]"
                                                                   id="character2_${index}" value="2">
                                                            <label class="form-check-label" for="character2_${index}">Nhân vật <span class="badge badge-question">2</span></label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <span class="item-child-lbl"><i class="fa fa-clock"></i>&nbsp;Time start:&nbsp;</span>
                                                        <span class="item-child-val">${convertSecondToTime(element.startTime)}</span>
                                                        <input name="actOutTimeStart[${index}]" hidden class="form-control form-control-sm" value="${element.startTime}">
                                                    </div>
                                                    <div>
                                                        <span class="item-child-lbl"><i class="fa fa-clock"></i>&nbsp;Time end:&nbsp;</span>
                                                        <span class="item-child-val">${convertSecondToTime(element.endTime)}</span>
                                                        <input name="actOutTimeEnd[${index}]" hidden class="form-control form-control-sm" value="${element.endTime}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <input name="actOutEn[${index}]" class="form-control form-control-sm" value="${element.en}">
                                                </td>
                                                <td>
                                                    <input name="actOutVi[${index}]" class="form-control form-control-sm" value="${element.vi}">
                                                </td>
                                            </tr>`;

                        });

                        htmlData += '</tbody>';
                        htmlData += '</table>';
                        $('#atcOutList').empty().append(htmlData);
                        $('.tagsinput').tagsinput('refresh');
                    },
                    error: function (xhr, status, error) {
                        console.log('error: ' + xhr.responseText);
                    }
                })
            }

        });

    });
</script>
