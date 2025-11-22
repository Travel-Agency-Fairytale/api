import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

export default function Logs(props) {
    function returnLogsRows(logs) {
        if (!logs.data || logs.data.length === 0) return <tbody><tr><td colSpan="4">No logs</td></tr></tbody>;
        return (
            <tbody>
            {logs.data.map((log) => (
                <tr key={log.id}>
                    <td>{log.id}</td>
                    <td>{log.level}</td>
                    <td>{log.message}</td>
                    <td>{new Date(log.created_at).toLocaleString(
                        'en-En',
                        {day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit'}
                    )}</td>
                </tr>
            ))}
            </tbody>
        );
    }
    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Logs
                </h2>
            }
        >
            <Head title="Logs" />
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Level</th>
                    <th>Message</th>
                    <th>Created At</th>
                </tr>
                </thead>
                {returnLogsRows(props.logs)}
            </table>
        </AuthenticatedLayout>
    );
}
