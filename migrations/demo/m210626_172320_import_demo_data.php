<?php
namespace app\migrations\demo;

use app\models\Brand;
use app\models\Car;
use app\models\Drive;
use app\models\Engine;
use app\models\Model;
use yii\db\Migration;

/**
 * Class m210626_172320_import_demo_data
 */
class m210626_172320_import_demo_data extends Migration
{
    public function up()
    {
        $this->createBrandsAndModels();
        $this->createEngines();
        $this->createDrives();

        for ($i = 0; $i < 25; $i++) {
            $this->createRandomCar();
        }
    }

    public function down()
    {
        echo "m210626_172320_import_demo_data cannot be reverted.\n";

        return false;
    }

    /**
     * Добавление марок и моделей
     */
    private function createBrandsAndModels(): void
    {
        $brandsWithModels = [
            'Lexus' => [
                'ES',
                'GX',
            ],
            'Toyota' => [
                'Camry',
                'Corolla',
            ],
        ];

        foreach ($brandsWithModels as $brand => $models) {
            $brandModel = new Brand([
                'name' => $brand
            ]);
            $brandModel->save();

            foreach ($models as $item) {
                $model = new Model([
                    'brand_id' => $brandModel->id,
                    'name' => $item
                ]);
                $model->save();
            }
        }
    }

    /**
     * Добавление двигателей
     */
    private function createEngines(): void
    {
        $engines = [
            'Бензин',
            'Дизель',
            'Гибрид',
        ];

        foreach ($engines as $engine) {
            $model = new Engine([
                'name' => $engine
            ]);
            $model->save();
        }
    }

    /**
     * Добавление приводов
     */
    private function createDrives(): void
    {
        $drives = [
            'Полный',
            'Передний',
        ];

        foreach ($drives as $drive) {
            $model = new Drive([
                'name' => $drive
            ]);
            $model->save();
        }
    }

    /**
     * Создание новой машины со случайными значениями
     */
    private function createRandomCar(): void
    {
        $brand = Brand::getRandom();
        $model = Model::getRandomRecordByBrand($brand);
        $engine = Engine::getRandom();
        $drive = Drive::getRandom();

        $car = new Car([
            'brand_id' => $brand->id,
            'model_id' => $model->id,
            'engine_id' => $engine->id,
            'drive_id' => $drive->id
        ]);

        $car->save();
    }
}