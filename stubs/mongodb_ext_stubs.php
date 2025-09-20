<?php
// IDE-only stubs for the MongoDB PHP extension types to satisfy static analyzers (e.g., Intelephense).
// Guard: if the mongodb extension is loaded, bail to avoid redeclaring classes.
namespace { if (\extension_loaded('mongodb')) { return; } }

namespace MongoDB\Driver {
    /**
     * @internal Stub for IDEs – real implementation provided by the MongoDB PHP extension.
     */
    class ReadPreference
    {
        public const PRIMARY = 1;
        public const PRIMARY_PREFERRED = 5;
        public const SECONDARY = 2;
        public const SECONDARY_PREFERRED = 6;
        public const NEAREST = 10;

        public function __construct(int $mode, ?array $tagSets = null, ?array $options = null) {}
    }
}

namespace MongoDB\Driver\Monitoring {
    /**
     * @internal Stub for IDEs – real implementation provided by the MongoDB PHP extension.
     */
    interface Subscriber {}
}

namespace MongoDB\Driver\Exception {
    /** @internal Stub base matching extension hierarchy */
    class RuntimeException extends \RuntimeException {}

    /** @internal Stub for IDEs */
    class AuthenticationException extends RuntimeException {}

    /** @internal Stub for IDEs */
    class ConnectionException extends RuntimeException {}
}
