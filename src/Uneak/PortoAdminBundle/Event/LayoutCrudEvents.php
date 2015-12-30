<?php

namespace Uneak\PortoAdminBundle\Event;

final class LayoutCrudEvents {
    const INITIALIZE = 'uneak.portoadmin.layout.crud.initialize';
    const LAYOUT_BUILD = 'uneak.portoadmin.layout.crud.layout.build';

    const FORM_INITIALIZE = 'uneak.portoadmin.layout.crud.form.initialize';
    const FORM_SUCCESS = 'uneak.portoadmin.layout.crud.form.success';
    const FORM_COMPLETE = 'uneak.portoadmin.layout.crud.form.complete';
    const FORM_ERROR = 'uneak.portoadmin.layout.crud.form.error';
}