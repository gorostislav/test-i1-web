$(function () {
    const SELECTORS = {
        'brand': '[name="brand"]',
        'model': '[name="model"]',
        'carList': '#car-list-block',
        'filterForm': 'form#car-filter',
        'pageInput': '[name = "page"]',
    };

    /**
     * Изменение полей в форме фильтрации
     */
    $('form#car-filter [name]').on('change', function () {
        let name = $(this).attr('name');

        if (name !== 'page') {
            $(SELECTORS.pageInput).val(null);
        }

        if (name === 'brand') {
            let boolVal = Boolean($(this).val()),
                $model = $(SELECTORS.model);

            $model.attr('disabled', !boolVal);

            if (!boolVal) {
                $model.val(null);
            }
        }

        $(SELECTORS.filterForm).trigger('submit');
    });

    /**
     * Отправка формы фильтрации
     */
    $('form#car-filter').on('beforeSubmit', function () {
        let $form = $(this),
            formData = $form.serializeArray(),
            newUrl = ['/catalog'],
            $carsBlock = $(SELECTORS.carList);

        formData.forEach(function (el) {

            switch (el.name) {
                case 'brand':
                    if (el.value !== '') {
                        newUrl.push(el.value);
                    }
                    break;
                case 'model':
                    if (newUrl.length > 1 && el.value !== '') {
                        newUrl.push(el.value);
                    }
                    break;

                default:
                    if (el.value !== '') {
                        newUrl.push(el.name + '=' + el.value);
                    }
                    break;
            }

        });

        $.ajax({
            type: 'get',
            url: $form.attr('action') + '?' + $form.serialize(),
            contentType: false,
            processData: false
        }).done(function (data) {

            data = data
                .replace('{brand}', $(SELECTORS.brand + ' option:selected').text())
                .replace('{model}', $(SELECTORS.model + ' option:selected').text());

            $carsBlock.html(data);

            let title = $carsBlock.find('.car-list-title').text();
            $('title').text(title);

            history.pushState(formData, title, newUrl.join('/'));
        });

        return false;
    });

    /**
     * Переключение страниц
     */
    $(SELECTORS.carList).on('click', '.pagination li a', function () {
        let page = new URLSearchParams($(this).attr('href')).get('page'),
            $form = $(SELECTORS.filterForm);

        $form.find('[name = "page"]').val(page).trigger('change');


        return false;
    })
});