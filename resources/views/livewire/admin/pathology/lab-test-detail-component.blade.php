<style>
    /* test&package detail */

    .testDetails_card {
        padding: 2em;
    }

    .testDetails_card {
        color: #6b788e;
    }

    .testDetails_card h1 {
        font-size: 20px;
        font-weight: 600;
        color: #091e42;
        margin-bottom: 0.25em;
    }

    .red__clr {
        color: #c5354e;
        font-weight: bold;
    }

    .testDetails_card h2 {
        font-size: 16px;
    }

    .testDetails_card p {
        font-size: 14px;
    }

    .testDetails_card .pricing {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: var(--fs-secondary-text);
    }

    .testDetails_card .original {
        text-decoration: line-through;
        color: #b3b9c4;
    }

    .testDetails_card .perc {
        color: #16c216;
        margin-left: 0.5em;
    }

    .testDetails_card .afterPrice p {
        font-size: var(--fs-primary-text);
        font-weight: 600;
        color: #091e42;
    }

    .testDetails_card button {
        flex-shrink: 0;
        border: 1px solid #c5354e !important;
        color: #c5354e;
        border-radius: 0.5rem;
        padding: 0.5em 3em;
        font-weight: 600;
        height: max-content;
    }

    @media all and (max-width: 580px) {

        .testDetails_card h1 {
            font-size: 14px;
        }


        .testDetails_card h2 {
            font-size: 12.625px;
        }

        .testDetails_card p {
            font-size: 10px;
        }

    }

    /* test&package detail */
</style>
<div class="bg-light container p-4">
    <div class="testDetails">
        <div class='testDetails_top bg-white'>
            <div class="testDetails_card">
                <div class="title d-flex flex-column flex-sm-row mb-3">
                <h1>{{ $var['testDetails']->testName }}</h1>
                    <div class="ml-sm-auto">
                        <div class="d-flex gap-3 align-items-center">
                            <h1 class="m-0">₹{{ $var['testDetails']->currentPrice }}</h1>
                            <h1 class="m-0 ml-sm-3 ml-2" style=" color: #6b788e;">₹{{ $var['testDetails']->actualPrice }}</h1>
                            <h1 class="text-success m-0 ml-sm-3 ml-2">{{$var['testDetails']->discountPercentage}}% Off</h1>
                        </div>
                    </div>
                </div>
                <div>
                    <p>{!! $var['testDetails']->packageLongDescription !!}
                    </p>
                </div>
                <div class="row justify-content-between">
                    <div class="col-12 col-md-auto">
                        <p>Home Sample Pickup</p>
                    </div>
                    <div class="col-12 col-md-auto">
                        <p><strong>Get reports </strong>: On same day</p>
                    </div>
                    <div class="col-12 col-md-auto">
                        <p class=""><strong>Sample</strong>: {{$var['testDetails']->sampleType}}</p>
                    </div>
                    <div class="col-12 col-md-auto">
                        <p class="mb-2"><strong>Test Requirements</strong>: Fasting Not Required</p>
                    </div>
                </div>

                @foreach($var['testList'] as $list)
                <div class="d-flex justify-content-between align-items-center mt-3 border-top pt-4 " data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    <div class="d-flex align-items-center">
                        <h2 class="">{{$list->testName}}</h2>
                        <h2 class="m-0 ml-2 red__clr">{{$list->testDescription}}</h2>
                    </div>
                    <div>
                        <i class="fa fa-angle-down"></i>
                    </div>
                </div>
                @endforeach
            
                <div class="bg-white mt-3 border-top pt-4">
                    <div class="row my-3 justify-content-around">
                        <div class="col-12 col-sm-auto mb-2">
                            <h2>About The Test : </h2>
                        </div>
                        <div class="col-12 col-sm-auto mb-2 ">
                            <h2 class="text-secondary">Home Sample Collection</h2>
                        </div>
                        <div class="col-12  col-sm-auto mb-2 ">
                            <h2 class="text-secondary">Gender {{$var['testDetails']->gender}}</h2>
                        </div>
                        <div class="col-12  col-sm-auto ">
                            <h2 class="text-secondary">All age group</h2>
                        </div>
                    </div>
                    <p class="text-secondary">What is the {{$var['testDetails']->testName}}  {{$var['testDetails']->testType=='1' ? 'individual':'Package'}} ?

                    {!! $var['testDetails']->precaution !!}
                        
                </div>
            </div>
        </div>
    </div>
</div>