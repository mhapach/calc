<div class="modal" id="client_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="client_form" method="post" action="" onsubmit="App.client.{{ $obj->exists ? 'update' : 'store' }}(this);return false;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Закрыть</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ $obj->exists ? 'Редактирование заказчика' : 'Добавление заказчика' }}</h4>
                </div>
                <div class="modal-body">
                    @if ($obj->exists)
                        <input type="hidden" id="id" disabled class="form-control" name="id" value="{{ $obj->id }}"/>
                    @endif

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label for="first_name">Имя</label>
                                <input type="text" tabindex="1" placeholder="Имя" class="form-control" id="first_name" name="first_name" value="{{ $obj->first_name }}">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label for="last_name">Фамилия</label>
                                <input type="text" tabindex="2" placeholder="Фамилия" class="form-control" id="last_name" name="last_name" value="{{ $obj->last_name }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" tabindex="3" placeholder="Email" class="form-control" id="email" name="email" value="{{ $obj->email }}">
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label for="phone">Телефон</label>
                                <input type="text" tabindex="4" placeholder="Телефон" class="form-control" id="phone" name="phone" value="{{ $obj->phone }}">
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label for="status">Статус</label>
                                {{ Form::select('status', Config::get('calc::client/statuses'), $obj->status, ['class' => 'form-control', 'tabindex' => '5']) }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label for="last_contact_at">Дата последнего звонка</label>
                                <input type="text" tabindex="6" placeholder="Дата последнего звонка" class="form-control datepicker" id="last_contact_at" name="last_contact_at" value="{{ $obj->last_contact_at }}">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label for="next_contact_at">Дата следующего звонка</label>
                                <input type="text" tabindex="7" placeholder="Дата след. звонка" class="form-control datepicker" id="next_contact_at" name="next_contact_at" value="{{ $obj->next_contact_at }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label for="type">Тип</label>
                                {{ Form::select('type', Config::get('calc::client/types'), $obj->type, ['class' => 'form-control', 'tabindex' => '8']) }}
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6"></div>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <label for="description">Описание</label>
                        <textarea tabindex="9" rows="4" class="form-control" id="description" name="description">{{ $obj->description }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
