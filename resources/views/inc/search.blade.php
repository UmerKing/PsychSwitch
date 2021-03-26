<div class="search_area pt-5" id="search-area">
    <div class="container">
        <div class="alert alert-danger" v-if="is_error_thrown" v-cloak>
            <ul>
                <li v-for="error in errors">@{{ error.message }}</li>
            </ul>
        </div>
        @include('flash-message')
        <?php
        $speciality_id = isset($params) ? $params["speciality_id"] : 0;
        $city_id = isset($params) ? $params["city_id"] : 0;
        ?>
        <div class="row">
            <div class="col-xl-12">
                <div class="section_title text-center mb-55">
                    <h3>Find a Doctor and book an appointment online</h3>
                </div>
                <div class="search_content">
                    <form action="/" method="post" novalidate="novalidate">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-12 pr-2">
                                        <select class="form-control search-slt" id="speciality_id" name="speciality_id"
                                                autocomplete="speciality_id">
                                            <option v-for="speciality in specialities"
                                                    v-bind:value="speciality.id"
                                                    :selected="speciality.id == {{ $speciality_id }} ? true : false ">
                                                @{{ speciality.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12 pr-2">
                                        <select class="form-control search-slt" id="exampleFormControlSelect1"
                                                name="country">
                                            <option value="Pakistan">Pakistan</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12 pr-2">
                                        <select class="form-control search-slt @error('city_id') is-invalid @enderror"
                                                id="city_id"
                                                name="city_id" autocomplete="city_id" required>
                                            <option v-for="city in cities" v-bind:value="city.id"
                                                    :selected="city.id == {{ $city_id }} ? true : false ">@{{ city.city
                                                }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="search-btn col-lg-3 col-md-3 col-sm-12 p-0">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    @if(isset($doctors_list))
                        @foreach($doctors_list as $doctor)
                            <div class="card mt-5">
                                <div class="row no-gutters">
                                    <div class="col-auto">
                                        <img src="https://www.w3schools.com/howto/img_avatar.png" class="img-fluid"
                                             width="200px" alt="">
                                    </div>
                                    <div class="col">
                                        <div class="card-block px-2">
                                            <h4 class="card-title pt-1">{{$doctor->name}}</h4>
                                            <span class="card-text">{{$doctor->speciality_name}}</span>
                                            <p>{{$doctor->about_me}}</p>
                                            <a href="/{{$doctor->user_id}}/book-appointment" class="btn btn-primary">Book
                                                an Appointment</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer w-100 text-muted">
                                    {{$doctor->address}}
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


