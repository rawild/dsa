<?php

namespace dsa\Http\ViewComposers;

use Illuminate\Contracts\View\View;


class HomeComposer
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
      $twoweeks = time() - (7 * 24 * 60 * 60 * 2);
      $events = \dsa\Event::with('neighborhood')->with('files')->with('volunteers')->where('Date','>', date('Y-m-d',$twoweeks))->where('id','!=','1')->orderby('Date', 'DESC')->get();
      $eventrows = array();
      foreach($events as $event){
        $totalrows = 0;
        foreach($event->files as $file){
          $totalrows = $totalrows + $file->TotalRows;
          $filenew = \dsa\File::with('user')->find($file->id);
          $file = $filenew;
        }
        $eventrows[$event->id] = $totalrows;
      }
      $view->with([
        'events' => $events,
        'eventrows' => $eventrows
      ]);
    }
}
