<div id="template-4" class="content-preview contact">
    <script type="text/javascript">
        var maps = [];
    </script>
    @foreach($contacts as $contact)
    <script type="text/javascript">
        maps.push({
            id : '{{$contact->id}}',
            lat : '{{$contact->latitude}}',
            long : '{{$contact->longitude}}',
            title: '{{$contact->title}}'
        });

    </script>
    <div id="map-{{$contact->id}}" class="maps"></div>
    <ul class="list-location">
        <li>
            <div class="table">
                <div class="table-cell">
                    <div class="left-table-cell">
                        <img src="https://m.ten-po.com/img/icon/f_location.png" alt="icon">
                    </div>
                    <div class="right-table-cell">
                        {{$contact->title}}
                    </div>
                </div>
            </div>
        </li>
        <li>
            <div class="table">
                <div class="table-cell">
                    <div class="left-table-cell">
                        <img src="https://m.ten-po.com/img/icon/f_time.png" alt="icon">
                    </div>
                    <div class="right-table-cell">
                        {{date('a h:i', strtotime($contact->start_time))}} - {{ date('a h:i', strtotime($contact->end_time)) }}
                    </div>
                </div>
            </div>

        </li>
        <li>
            <div class="table">
                <div class="table-cell">
                    <div class="left-table-cell">
                        <img src="https://m.ten-po.com/img/icon/f_tel.png" alt="icon">
                    </div>
                    <div class="right-table-cell">
                        <a class="text-phone" href="tel:(454) 543-1653 x9733">{{$contact->tel}}</a>
                    </div>
                </div>
            </div>

        </li>
    </ul>

    <a href="#" class="btn tenposs-button">予約</a>
    @endforeach
</div>