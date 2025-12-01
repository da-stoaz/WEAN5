using DeviceApiForMobile.Data;
using DeviceApiForMobile.DeviceInfo;
using Microsoft.AspNetCore.Http.HttpResults;
using Microsoft.EntityFrameworkCore;
using Scalar.AspNetCore;

namespace DeviceApiForMobile;

public class Program
{
    public static void Main(string[] args)
    {
        var builder = WebApplication.CreateBuilder(args);

        // Add services to the container.
        builder.Services.AddAuthorization();

        builder.Services.AddDbContext<DeviceDbContext>(options => { options.UseSqlite("Data Source=device.db"); });

        // Learn more about configuring OpenAPI at https://aka.ms/aspnet/openapi
        builder.Services.AddOpenApi();

        var app = builder.Build();

        // Configure the HTTP request pipeline.
        if (app.Environment.IsDevelopment())
        {
            app.MapScalarApiReference();
            app.MapOpenApi();
        }

        app.UseHttpsRedirection();

        app.UseAuthorization();

     

        app.MapGet("/devices", async (DeviceDbContext db) =>
            {
                var devices = await db.DeviceInfos.ToListAsync();
                return Results.Ok(devices);
            })
            .WithName("GetDevices");

        app.MapPost("/devices", async (CreateDeviceInfoModel createInfo, DeviceDbContext db) =>
            {
                var device = new DeviceInfo.DeviceInfo
                {
                    DeviceName = createInfo.DeviceName,
                    Manufacturer = createInfo.Manufacturer,
                    Description = createInfo.Description,
                    SerialNumber = createInfo.SerialNumber,
                    UpdatedAt =  DateTime.UtcNow
                };
                db.DeviceInfos.Add(device);
                await db.SaveChangesAsync();
                return Results.Created($"/devices/{device.Id}", device);
            })
            .WithName("CreateDevice");
        
        app.MapPut("/devices/{id}", async (Guid id, CreateDeviceInfoModel updateInfo, DeviceDbContext db) =>
        {
            var device = await db.DeviceInfos.FindAsync(id);
            if (device == null)
                return Results.NotFound();
            
   
            db.Entry(device).CurrentValues.SetValues(updateInfo);
            device.UpdatedAt = DateTime.UtcNow;

            
            await db.SaveChangesAsync();
            return Results.Ok(device);
        }).WithName("UpdateDevice");

        app.MapDelete("/devices/{id}", async (Guid id, DeviceDbContext db) =>
        {
            var info = await db.DeviceInfos.FindAsync(id);
            if (info == null)
                return Results.NotFound();
            
            db.DeviceInfos.Remove(info);
            await db.SaveChangesAsync();
            
            return Results.NoContent();
        }).WithName("DeleteDevice");


        app.Run();
    }
}