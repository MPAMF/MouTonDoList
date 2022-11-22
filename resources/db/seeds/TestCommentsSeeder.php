<?php


use Phinx\Seed\AbstractSeed;

class TestCommentsSeeder extends AbstractSeed
{

    private array $comments = [
        "ultrices posuere cubilia Curae Donec tincidunt. Donec vitae erat vel pede",
        "at sem molestie sodales. Mauris blandit enim consequat purus. Maecenas libero",
        "at, velit.",
        "tortor at risus. Nunc ac sem ut dolor dapibus gravida. Aliquam tincidunt, nunc ac",
        "Integer sem elit, pharetra ut, pharetra sed,",
        "risus. Nunc ac sem ut dolor dapibus gravida. Aliquam",
        "massa rutrum magna. Cras convallis convallis dolor.",
        "consequat dolor vitae dolor. Donec fringilla. Donec feugiat metus",
        "odio, auctor vitae, aliquet nec, imperdiet nec, leo. Morbi neque tellus, imperdiet non, vestibulum",
        "sem. Pellentesque ut ipsum ac mi eleifend egestas. Sed pharetra, felis eget varius ultrices, mauris",
        "mattis semper, dui lectus rutrum urna, nec luctus",
        "diam dictum sapien. Aenean massa. Integer vitae nibh. Donec est mauris, rhoncus id, mollis nec,",
        "cursus, diam at pretium aliquet,",
        "erat eget ipsum. Suspendisse sagittis. Nullam vitae diam. Proin dolor. Nulla semper",
        "id enim. Curabitur massa. Vestibulum accumsan neque et nunc. Quisque ornare tortor at risus. Nunc",
        "varius et, euismod et, commodo at, libero. Morbi",
        "fermentum convallis ligula. Donec luctus aliquet odio. Etiam ligula tortor, dictum",
        "vulputate mauris",
        "augue ac ipsum. Phasellus vitae mauris sit amet lorem semper auctor. Mauris vel turpis.",
        "vitae aliquam eros turpis non enim. Mauris quis turpis vitae purus gravida",
        "molestie tellus. Aenean egestas hendrerit neque. In ornare sagittis",
        "eu, odio. Phasellus at augue id ante dictum cursus.",
        "a purus. Duis elementum, dui quis accumsan convallis, ante lectus convallis",
        "eleifend vitae, erat. Vivamus nisi. Mauris nulla. Integer urna. Vivamus molestie dapibus",
        "Nullam suscipit, est",
        "lectus, a sollicitudin orci sem",
        "dolor. Fusce mi lorem, vehicula et, rutrum eu, ultrices sit amet, risus.",
        "luctus et ultrices posuere cubilia Curae Donec tincidunt. Donec vitae erat vel pede blandit",
        "tempor bibendum. Donec felis orci, adipiscing non, luctus sit amet,",
        "nisi a odio semper cursus. Integer mollis. Integer tincidunt aliquam arcu. Aliquam",
        "natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean eget magna.",
        "sem semper erat, in consectetuer ipsum nunc id enim. Curabitur massa. Vestibulum accumsan",
        "porta elit, a feugiat tellus lorem eu metus. In lorem. Donec elementum, lorem",
        "non enim. Mauris quis turpis vitae purus gravida sagittis.",
        "lobortis tellus justo sit amet nulla. Donec non justo. Proin non",
        "ullamcorper, velit in aliquet lobortis, nisi nibh",
        "primis in faucibus orci luctus et ultrices posuere cubilia",
        "bibendum fermentum metus. Aenean sed pede nec ante blandit viverra. Donec tempus, lorem fringilla ornare",
        "viverra. Maecenas iaculis aliquet diam. Sed diam lorem,",
        "eget, dictum placerat, augue. Sed molestie. Sed id risus quis",
        "orci, in consequat enim",
        "libero. Integer in magna. Phasellus dolor elit, pellentesque a, facilisis",
        "feugiat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam auctor, velit eget laoreet posuere,",
        "a tortor. Nunc commodo auctor velit. Aliquam",
        "nunc. Quisque ornare tortor at risus. Nunc ac sem ut",
        "nec, imperdiet nec, leo. Morbi neque tellus, imperdiet non, vestibulum nec, euismod in, dolor.",
        "amet orci. Ut sagittis lobortis mauris. Suspendisse aliquet molestie tellus. Aenean",
        "Cras dictum ultricies ligula.",
        "Fusce mi lorem, vehicula et, rutrum eu, ultrices sit",
        "Sed congue, elit sed consequat auctor, nunc nulla",
        "luctus sit amet, faucibus ut, nulla. Cras",
        "mattis. Cras eget nisi dictum augue malesuada malesuada. Integer id magna",
        "a tortor.",
        "a, auctor non, feugiat nec, diam. Duis mi",
        "aliquam eros turpis non enim. Mauris quis turpis vitae purus gravida sagittis.",
        "arcu vel quam dignissim pharetra.",
        "eget odio.",
        "non sapien molestie orci tincidunt adipiscing. Mauris molestie",
        "Phasellus at augue id ante dictum cursus. Nunc mauris elit, dictum eu, eleifend",
        "vel turpis. Aliquam adipiscing lobortis risus. In mi pede, nonummy ut, molestie in, tempus",
        "magna. Praesent interdum ligula eu enim. Etiam imperdiet dictum magna.",
        "Nulla semper tellus id",
        "cursus. Nunc mauris elit, dictum eu, eleifend nec, malesuada ut, sem.",
        "ligula. Aenean euismod mauris eu elit. Nulla facilisi. Sed",
        "dui, nec tempus mauris",
        "nibh sit amet orci. Ut sagittis lobortis mauris. Suspendisse aliquet molestie",
        "eu, ultrices sit amet, risus. Donec nibh enim, gravida sit amet, dapibus id,",
        "pretium aliquet, metus urna convallis erat, eget tincidunt dui augue",
        "pharetra. Quisque ac libero nec ligula consectetuer rhoncus. Nullam velit dui, semper et,",
        "sed pede nec ante blandit viverra. Donec tempus, lorem fringilla ornare",
        "non enim. Mauris quis turpis vitae purus gravida sagittis. Duis gravida. Praesent eu",
        "lorem, eget mollis lectus pede et risus. Quisque libero lacus, varius",
        "nibh. Phasellus nulla. Integer vulputate,",
        "nec ante. Maecenas",
        "vitae nibh. Donec est mauris, rhoncus id, mollis nec, cursus a, enim.",
        "nunc, ullamcorper eu, euismod ac, fermentum",
        "tempor lorem, eget mollis",
        "ridiculus mus. Aenean eget magna. Suspendisse tristique neque venenatis lacus. Etiam bibendum fermentum metus. Aenean",
        "vitae odio sagittis semper. Nam tempor diam dictum sapien. Aenean",
        "accumsan neque et nunc. Quisque ornare tortor at risus. Nunc",
        "ipsum primis in faucibus orci luctus et",
        "dignissim. Maecenas ornare egestas ligula.",
        "tellus. Phasellus elit pede, malesuada vel, venenatis vel, faucibus id,",
        "Fusce dolor quam, elementum at, egestas a, scelerisque sed, sapien. Nunc pulvinar",
        "ultricies ligula. Nullam enim. Sed nulla ante, iaculis nec, eleifend non, dapibus rutrum, justo.",
        "aliquet vel, vulputate eu,",
        "mus. Proin vel nisl. Quisque fringilla euismod enim. Etiam gravida molestie arcu. Sed eu nibh",
        "Donec at arcu. Vestibulum ante ipsum primis in",
        "Maecenas malesuada fringilla est.",
        "semper, dui lectus rutrum urna, nec luctus felis purus ac",
        "Aenean eget magna. Suspendisse tristique neque venenatis",
        "quis, tristique ac, eleifend vitae, erat. Vivamus nisi. Mauris",
        "egestas ligula. Nullam feugiat placerat velit. Quisque varius. Nam porttitor scelerisque neque.",
        "a ultricies adipiscing, enim mi tempor lorem, eget mollis lectus pede et risus.",
        "libero. Proin sed turpis nec mauris blandit mattis. Cras eget nisi dictum augue malesuada malesuada.",
        "dui quis accumsan convallis, ante lectus",
        "nec metus facilisis lorem tristique aliquet. Phasellus fermentum",
        "felis ullamcorper viverra. Maecenas iaculis aliquet diam. Sed diam lorem, auctor quis,",
        "nibh. Donec est",
        "cursus a, enim. Suspendisse aliquet, sem ut cursus luctus, ipsum leo elementum sem,"
    ];

    public function getDependencies(): array
    {
        return [
            'TestTasksSeeder',
        ];
    }

    private function generateRandomComment($task_id): array
    {
        $user_id = rand(1, 4);
        $comment = $this->comments[rand(0, count($this->comments) - 1)];

        return [
            'author_id' => $user_id,
            'content' => $comment,
            'task_id' => $task_id
        ];
    }

    public function run(): void
    {
        $data = [];

        for ($i = 1; $i <= 216; $i++)
        {
            $data[] = $this->generateRandomComment($i);
        }

        $task_comments = $this->table('task_comments');
        $task_comments->insert($data)->saveData();
    }
}
