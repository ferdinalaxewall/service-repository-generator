<?php

namespace Ferdinalaxewall\ServiceRepositoryGenerator;

class Define
{
    /**
     * give the value for available type of generators.
     *
     * @var array<string>
     */
    CONST AVAILABLE_TYPE = ['service', 'repository'];

    /**
     * give the value for base repository file path.
     *
     * @var string
     */
    CONST BASE_REPOSITORY_FILE_PATH = '/BaseRepository.php';

    /**
     * give the value for service type definition.
     *
     * @var string
     */
    CONST SERVICE_TYPE = 'service';

    /**
     * give the value for service path definition.
     *
     * @var string
     */
    CONST SERVICE_PATH = 'app/Services';

    /**
     * give the value for repository type definition.
     *
     * @var string
     */
    CONST REPOSITORY_TYPE = 'repository';

    /**
     * give the value for repository path definition.
     *
     * @var string
     */
    CONST REPOSITORY_PATH = 'app/Repositories';
}
