<?php

namespace dsa\Http\ViewComposers;

use Illuminate\Contracts\View\View;


class AdminHomeComposer
{

    public function __construct( )
    {

    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
      $events = \dsa\Event::with('neighborhood')->with('volunteers')->where('id', '!=', '1')->orderby('Date', 'DESC')->get();
      $view->with([
        'events' => $events,
      ]);
    }
}
