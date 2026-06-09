@if(isset(Auth::user()->email))
    @extends('layout/admin_dashboard')
@else
    <script>window.location="/admin";</script>
@endif 
    
@section('title', 'Admin Kelola Publikasi')

@section('main')
    
    @if(isset(Auth::user()->email))
        <!-- MAIN -->
        <div class="col">
            <div class="mt-5">
                <div id="chart"></div>
            </div>
            <div class="single-pricing">
                <div class="single-pricing-content">
                    <h5>Kelola Data Publikasi</h5>
                    @if (session('status'))
                        <div class='alert alert-success'>
                            {{ session('status')}}
                        </div>
                    @endif
                    <a href="/admin/successlogin/kelola-publikasi/create" class="btn btn-primary mb-3 btn-sm" style="color:#fff; font-size:14px">Tambah Data</a>

                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-hover" style="font-size:13px;">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Jenis</th>
                                    <th>Kategori Reputasi</th>
                                    <th>Pengupload</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach( $publikasis as $i => $pub )
                                <tr>
                                    <td>{{ $publikasis->firstItem() + $i }}</td>
                                    <td>{{ $pub->judul }}</td>
                                    <td>
                                        <span class="badge badge-{{ $pub->jenis_publikasi === 'Jurnal' ? 'success' : 'info' }}">
                                            {{ $pub->jenis_publikasi }}
                                        </span>
                                    </td>
                                    <td>{{ $pub->kategori_reputasi }}</td>
                                    <td>{{ $pub->user->name ?? '-' }}</td>
                                    <td>
                                        <a href="/admin/successlogin/kelola-publikasi/{{ $pub->id }}/edit" class="btn btn-outline-info btn-sm mr-1" style="color:#000; font-size:10px">Edit</a>
                                        
                                        <form action="/admin/successlogin/kelola-publikasi/{{ $pub->id }}" method="post" style="display:inline;">
                                            @csrf
                                            @method('DELETE') 
                                            <button class="btn btn-outline-danger btn-sm" style="color:#000; font-size:10px" onclick="return confirm('Yakin ingin menghapus?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <nav class="blog-pagination justify-content-center d-flex">
                        <ul class="pagination">
                            <li class="page-item">
                                {{ $publikasis->links() }}
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    @else
        <script>window.location="/admin";</script>
    @endif

    @section('script')
        <script src="https://code.highcharts.com/highcharts.js"></script>

        <script>
            Highcharts.chart('chart', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Jumlah Data Publikasi per Jenis'
                },
                xAxis: {
                    categories: ['Jurnal', 'Prosiding'],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Jumlah Data'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Publikasi',
                    data: [{{$countJurnal}}, {{$countProsiding}}]
                }]
            });
        </script>

    @endsection
@endsection
