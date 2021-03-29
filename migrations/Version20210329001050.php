<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210329001050 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Product configurations view';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
        /** @lang SQL */
            "CREATE VIEW product_conf_view AS 
                select
                pconf.id,
                (
                    SELECT name
                    FROM product 
                    where pconf.product_id = product.id
                ) AS name,
                (
                    SELECT base_price
                    FROM product 
                    where pconf.product_id = product.id
                ) AS base_price,
                pconf.depth,
                pconf.d_b1,
                pconf.d_b2,
                pconf.d_b5,
                pconf.d_b10,
                pconf.discr,
                rectconf.width,
                rectconf.height,
                rectconf.thickness,
                circconf.diameter,
                (
                    select case pconf.discr 
                    when 'rect' then (
                        select (rectconfsub.height + rectconfsub.width) 
                        from rect_product_configuration AS rectconfsub 
                        where pconfsub.id = rectconfsub.id
                    ) 
                    when 'circ' then (
                        select pi() * pow((circconfsub.diameter / 2), 2)
                        from circ_product_configuration AS circconfsub 
                        where pconfsub.id = circconfsub.id
                    )
                    else ''
                    end
                    from product_configuration AS pconfsub
                    where pconf.id = pconfsub.id
                ) AS `area` 
                from product_configuration AS pconf 
                left join rect_product_configuration AS rectconf
                on pconf.id = rectconf.id 
                left join circ_product_configuration AS circconf
                on pconf.id = circconf.id
                where pconf.id is not null
                UNION
                select 
                pconf.id,
                (
                    SELECT name
                    FROM product 
                    where pconf.product_id = product.id
                ) AS name,
                (
                    SELECT base_price
                    FROM product 
                    where pconf.product_id = product.id
                ) AS base_price,
                pconf.depth,
                pconf.d_b1,
                pconf.d_b2,
                pconf.d_b5,
                pconf.d_b10,
                pconf.discr,
                rectconf.width,
                rectconf.height,
                rectconf.thickness,
                circconf.diameter,
                (
                    select case pconf.discr 
                    when 'rect' then (
                        select (rectconfsub.height + rectconfsub.width) 
                        from rect_product_configuration AS rectconfsub 
                        where pconfsub.id = rectconfsub.id
                    ) 
                    when 'circ' then (
                        select pi() * pow((circconfsub.diameter / 2), 2)
                        from circ_product_configuration AS circconfsub 
                        where pconfsub.id = circconfsub.id
                    )
                    else ''
                    end
                    from product_configuration AS pconfsub
                    where pconf.id = pconfsub.id
                ) AS `area` 
                from product_configuration AS pconf 
                right join rect_product_configuration AS rectconf
                on pconf.id = rectconf.id 
                right join circ_product_configuration AS circconf
                on pconf.id = circconf.id
                where pconf.id is not null"
        );

    }

    public function down(Schema $schema): void
    {
        $this->addSql(
        /** @lang SQL */
            "DROP VIEW product_conf_view"
        );
    }
}
