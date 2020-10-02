<?php

namespace App\Http\Controllers;

use Osen\Updater\UpdaterManager;

class UpdateController extends Controller
{
    public function check(UpdaterManager $updater)
    {
        try {
            if ($updater->source()->isNewVersionAvailable()) {
                $source     = $updater->source()->getVersionInstalled();
                $upgradable = $updater->source()->getVersionAvailable();
                $title      = "New version available for upgrade";
                $message    = "New version available for upgrade";
                session()->put('update', $upgradable);
            } else {
                $upgradable = null;
                $title      = "No new version available for upgrade";
                $message    = "You have the lates version installed";
            }
        } catch (\Throwable $th) {
            $message    = $th->getMessage();
            $upgradable = null;
            $title      = 'An error occured';
        }

        return view('updates', compact('upgradable', 'message', 'title'));
    }

    public function upgrade(UpdaterManager $updater)
    {
        if ($updater->source()->isNewVersionAvailable()) {
            echo $updater->source()->getVersionInstalled();
            $upgradable = $updater->source()->getVersionAvailable();
            $release    = $updater->source()->fetch($upgradable);
            $updater->source()->update($release);
            return redirect('updates?upgrade=success');
        } else {
            return redirect('updates/check?upgrade=unavailable');
        }
    }
}
