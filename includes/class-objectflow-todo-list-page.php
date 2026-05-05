<?php

if (!defined('ABSPATH')) {
    exit;
}

final class ObjectFlow_Todo_List_Page {
    /**
     * Placeholder for upcoming filter configuration.
     *
     * @var array<string, mixed>
     */
    private array $future_filters = [];

    /**
     * Placeholder for upcoming related-table expansion config.
     *
     * @var array<string, mixed>
     */
    private array $future_relations = [];

    public function register_submenu(string $parent_slug): void {
        add_submenu_page(
            $parent_slug,
            __('Todo List', 'objectflow-sandbox'),
            __('Todo List', 'objectflow-sandbox'),
            'manage_options',
            'objectflow-todo-list',
            [$this, 'render_page'],
            1
        );
    }

    public function render_page(): void {
        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('Unauthorized request.', 'objectflow-sandbox'));
        }

        $rows = $this->get_todo_rows();
        ?>
        <div class="wrap">
            <h1><?php echo esc_html__('Todo List', 'objectflow-sandbox'); ?></h1>
            <?php if (empty($rows)) : ?>
                <p><?php echo esc_html__('No todo records found.', 'objectflow-sandbox'); ?></p>
            <?php else : ?>
                <table class="widefat striped">
                    <thead>
                        <tr>
                            <?php foreach (array_keys($rows[0]) as $column_name) : ?>
                                <th><?php echo esc_html((string) $column_name); ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $row) : ?>
                            <tr>
                                <?php foreach ($row as $value) : ?>
                                    <td><?php echo esc_html((string) $value); ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
        <?php
    }

    private function get_todo_rows(): array {
        global $wpdb;
        $table_name = 'oflow_todo';

        $exists = $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $table_name));
        if ($exists !== $table_name) {
            return [];
        }

        $results = $wpdb->get_results('SELECT * FROM `oflow_todo` ORDER BY ID DESC', ARRAY_A);

        return is_array($results) ? $results : [];
    }
}
