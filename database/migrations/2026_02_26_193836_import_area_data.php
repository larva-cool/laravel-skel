<?php

use App\Models\System\Area;
use App\Support\FileHelper;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $district = FileHelper::json(database_path('data/district-20250328.json'));
        foreach ($district['result'] as $item) {// 省
            $areaId = Area::insertGetId([
                'name' => $item['fullname'],
                'area_code' => $item['id'],
                'lat' => $item['location']['lat'],
                'lng' => $item['location']['lng'],
            ]);
            foreach ($item['districts'] as $dit) {// 市
                $cityArea = Area::create([
                    'parent_id' => $areaId,
                    'name' => $dit['fullname'],
                    'area_code' => $dit['id'],
                    'lat' => $dit['location']['lat'],
                    'lng' => $dit['location']['lng'],
                ]);
                if (isset($dit['districts'])) {// 区
                    foreach ($dit['districts'] as $subDit) {
                        Area::create([
                            'parent_id' => $cityArea->id,
                            'name' => $subDit['fullname'],
                            'area_code' => $subDit['id'],
                            'lat' => $subDit['location']['lat'],
                            'lng' => $subDit['location']['lng'],
                        ]);
                    }
                }
            }
        }
        unset($district);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Area::truncate();
    }
};
