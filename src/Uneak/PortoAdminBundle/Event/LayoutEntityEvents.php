<?php

namespace Uneak\PortoAdminBundle\Event;

final class LayoutEntityEvents {
    const INITIALIZE = 'uneak.portoadmin.layout.crud.initialize';

    const LAYOUT_CREATE = 'uneak.portoadmin.layout.crud.layout.create';
    const LAYOUT_INITIALIZE = 'uneak.portoadmin.layout.crud.layout.initialize';

    const FORM_CREATE = 'uneak.portoadmin.layout.crud.form.create';
    const FORM_INITIALIZE = 'uneak.portoadmin.layout.crud.form.initialize';
    const FORM_SUCCESS = 'uneak.portoadmin.layout.crud.form.success';
    const FORM_COMPLETE = 'uneak.portoadmin.layout.crud.form.complete';
    const FORM_ERROR = 'uneak.portoadmin.layout.crud.form.error';

    const GRID_PARAMS_CREATE = 'uneak.portoadmin.layout.crud.grid.params.create';
    const GRID_PARAMS_INITIALIZE = 'uneak.portoadmin.layout.crud.grid.params.initialize';
    const GRID_DATATABLE = 'uneak.portoadmin.layout.crud.grid.datatable';

    const FLASH_ERROR = 'uneak.portoadmin.layout.crud.flash.error';
    const FLASH_SUCCESS = 'uneak.portoadmin.layout.crud.flash.success';
}