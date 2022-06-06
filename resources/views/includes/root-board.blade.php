<div class="row-fluid row">
    <div class="col-sm-6">
        @include('includes.panel', ['name'=>'all', 'limit'=>22])
    </div>
    <div class="col-sm-6">
        @include('includes.panel', ['name'=>'free', 'limit'=>5])
        @include('includes.panel', ['name'=>'quot', 'limit'=>3])
        @include('includes.panel', ['name'=>'qna', 'limit'=>5])
    </div>
</div>
<div class="row-fluid row">
    <div class="col-sm-6">
        @include('includes.panel', ['name'=>'notice', 'limit'=>4])
        @include('includes.panel', ['name'=>'school', 'limit'=>3])
{{--        @include('includes.panel', ['name'=>'unreg', 'limit'=>3])--}}
    </div>
    <div class="col-sm-6">
        @include('includes.panel', ['name'=>'sell', 'limit'=>10])
        @include('includes.panel', ['name'=>'buy', 'limit'=>5])
    </div>
</div>
<div class="row-fluid row">
    <div class="col-sm-6">
        @include('includes.panel', ['name'=>'dog', 'limit'=>5])
    </div>
    <div class="col-sm-6">
        @include('includes.panel', ['name'=>'anon', 'limit'=>5])
    </div>
</div>
<div class="row-fluid row">
    <div class="col-sm-6">
        @include('includes.panel', ['name'=>'cat', 'limit'=>5])
    </div>
    <div class="col-sm-6">
        @include('includes.panel', ['name'=>'inquiry', 'limit'=>5])
    </div>
</div>
{{--
<div class="row-fluid row">
    <div class="col-sm-6">
        @include('includes.panel', create('inquiry', 5, $boards))
    </div>
    <div class="col-sm-6">
        @include('includes.panel', create('inquiry', 5, $boards))
    </div>
</div>
--}}
